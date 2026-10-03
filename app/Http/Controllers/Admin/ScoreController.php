<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamSession;
use App\Models\Score;
use App\Models\Candidate;
use App\Models\Competency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
public function indexForSession(ExamSession $exam_session)
{
    $candidates = Candidate::where('exam_session_id', $exam_session->id)
        ->with('centre')
        ->orderBy('last_name')
        ->get();

    $competencies = Competency::where('exam_id', $exam_session->exam_id)->get();

    $scores = Score::where('exam_session_id', $exam_session->id)
        ->get()
        ->groupBy(fn($s) => $s->candidate_id.'-'.$s->competency_id);

    return view('admin.scores.index', compact(
        'exam_session', 
        'candidates', 
        'competencies', 
        'scores'
    ));
}

    /**
     * Affiche les scores d’une session
     */
    public function index(ExamSession $exam_session)
    {
        $candidates = Candidate::where('exam_session_id', $exam_session->id)
            ->with('centre')
            ->orderBy('last_name')
            ->get();

        $competencies = Competency::where('exam_id', $exam_session->exam_id)->get();

        // Charger les scores existants
        $scores = Score::where('exam_session_id', $exam_session->id)
            ->get()
            ->groupBy(fn($s) => $s->candidate_id.'-'.$s->competency_id);

        return view('admin.scores.index', compact(
            'exam_session', 
            'candidates', 
            'competencies', 
            'scores'
        ));
    }

    public function edit(Score $score)
{
    return view('admin.scores.edit', compact('score'));
}


public function create()
{
    //abort(404); // ou rediriger vers indexForSession
}

    // public function update(Request $request, Score $score)
    // {
    //     // Validation
    //     $request->validate([
    //         'score' => 'required|numeric|min:0|max:20',
    //         'status' => 'required|in:present,absent,ajourne',
    //     ]);

    //     // Mise à jour du score
    //     $score->score = $request->score;
    //     $score->status = $request->status;

    //     // Validation par jury si bouton "Valider" cliqué
    //     if ($request->has('validate') && !$score->validated_at) {
    //         $score->validated_at = now();
    //         $score->validated_by = auth()->id();
    //     }

    //     $score->save();

    //     return redirect()->route('admin.exam_sessions.show', $score->session->id)
    //                      ->with('success', 'Score mis à jour avec succès.');
    // }
    public function update(Request $request, Score $score)
    {
        $request->validate([
            'score' => 'nullable|numeric|min:0|max:20',
            'status' => 'required|in:present,absent,ajourne',
        ]);

        if ($score->validated_at) {
            return back()->with('warning', 'Score déjà validé, modification impossible.');
        }

        $score->update([
            'score' => $request->score,
            'status' => $request->status,
            'entered_by' => Auth::id(),
        ]);

        return back()->with('success', 'Score mis à jour.');
    }

    /**
     * Enregistrer ou mettre à jour un score
     */
   public function store(Request $request)
{
    $sessionId = $request->exam_session_id;

    foreach ($request->scores as $candidateId => $compScores) {

        foreach ($compScores as $competencyId => $data) {

            // Chercher un score existant
            $score = Score::where('exam_session_id', $sessionId)
                ->where('candidate_id', $candidateId)
                ->where('competency_id', $competencyId)
                ->first();

            // 🔒 Ne pas modifier si déjà validé
            if ($score && $score->validated_at) {
                continue;
            }

            // Sinon : mise à jour ou création
            Score::updateOrCreate(
                [
                    'exam_session_id' => $sessionId,
                    'candidate_id' => $candidateId,
                    'competency_id' => $competencyId,
                ],
                [
                    'score' => $data['score'] ?? null,
                    'status' => $data['status'] ?? 'present',
                ]
            );
        }
    }

    return back()->with('success', 'Scores enregistrés avec succès.');
}



    /**
     * Valider un score
     */
// public function validateScore(Request $request)
// {
//     $request->validate([
//         'exam_session_id' => 'required|exists:exam_sessions,id',
//         'candidate_id' => 'required|exists:candidates,id',
//         'competency_id' => 'required|exists:competencies,id',
//     ]);

//     $score = Score::where('exam_session_id', $request->exam_session_id)
//         ->where('candidate_id', $request->candidate_id)
//         ->where('competency_id', $request->competency_id)
//         ->firstOrFail();

//     // Vérrouiller
//     $score->validated_by = Auth::id();
//     $score->validated_at = now();
//     $score->save();

//     return response()->json([
//         'success' => true,
//         'message' => "Score validé."
//     ]);
// }
    public function validateScore(Request $request)
    {
        $request->validate([
            'exam_session_id' => 'required',
            'candidate_id' => 'required',
            'competency_id' => 'required',
        ]);

        $score = Score::firstOrCreate([
            'exam_session_id' => $request->exam_session_id,
            'candidate_id' => $request->candidate_id,
            'competency_id' => $request->competency_id,
        ]);

        // Mise à jour avant validation
        $score->score = $request->score;
        $score->status = $request->status ?? 'present';
        $score->validated_by = Auth::id();
        $score->validated_at = now();
        $score->save();

        return response()->json([
            'success' => true,
            'validatedBy' => $score->validatedBy->name,
            'message' => 'Score validé.'
        ]);
    }


public function unlockScore(Request $request)
{
    $score = Score::where('exam_session_id', $request->exam_session_id)
        ->where('candidate_id', $request->candidate_id)
        ->where('competency_id', $request->competency_id)
        ->firstOrFail();

    $score->validated_by = null;
    $score->validated_at = null;
    $score->save();

    return response()->json(['success' => true]);
}


    public function show(ExamSession $exam_session)
{
    $candidates = Candidate::where('exam_session_id', $exam_session->id)
        ->with('centre')
        ->orderBy('last_name')
        ->get();

    $competencies = Competency::where('exam_id', $exam_session->exam_id)->get();

    // Charger les scores existants
    $scores = Score::where('exam_session_id', $exam_session->id)
        ->get()
        ->groupBy(fn($s) => $s->candidate_id.'-'.$s->competency_id);

    return view('admin.scores.show', compact(
        'exam_session', 
        'candidates', 
        'competencies', 
        'scores'
    ));
}

}
