<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use App\Models\Centre;
use App\Models\Exam;

class ExamSessionController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('super-admin') || $user->hasRole('ministere')) {
            $sessions = ExamSession::with('exam','centre')->get();
        } elseif ($user->hasRole('centre-admin')) {
            $sessions = ExamSession::where('centre_id', $user->centre_id)
                ->with('exam')
                ->get();
        }

        return view('admin.exam_sessions.index', compact('sessions'));
    }


    public function create()
    {
        $centres = Centre::all();
        $exams = Exam::all();
        return view('admin.exam_sessions.create', compact('centres', 'exams'));
    }

    public function byCentre(Centre $centre)
    {
        $sessions = ExamSession::with('exam')
            ->where('centre_id', $centre->id)
            ->orderBy('exam_id')
            ->orderBy('start_date')
            ->get()
            ->groupBy(fn ($s) => $s->exam->title);

        return view('admin.exam_sessions.by_centre', compact('centre', 'sessions'));
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'centre_id' => 'required|exists:centres,id',
            'exam_id' => 'required|exists:exams,id',
            'academic_year' => 'nullable|string',
            'type' => 'nullable|string',
            'settings' => 'nullable|array',
        ]);

        ExamSession::create($data);

        return redirect()
            ->route('admin.exam_sessions.index')
            ->with('success','Session créée');
    }

    // public function show(Exam $exam, ExamSession $exam_session)
    // {
    //     $exam_session->load('centre', 'candidates', 'scores', 'documents',
    //     'scores.candidate',
    //     'scores.exam');
    //     return view('admin.exam_sessions.show', compact('exam_session'));
    // }
    public function show(Exam $exam, ExamSession $exam_session)
    {
        $exam_session->load([
            'centre',
            'candidates',
            'scores',
            'documents',
            'scores.candidate',
            'scores.exam',
            'exam.competencies',   // ✔ charger les compétences de l’examen
        ]);

        return view('admin.exam_sessions.show', compact('exam_session'));
    }


    public function edit(ExamSession $exam_session)
    {
        $session = $exam_session;
        $centres = Centre::all();
        $exams = Exam::all();

        return view('admin.exam_sessions.edit', compact('session', 'centres', 'exams'));
    }

    public function update(Request $request, ExamSession $exam_session)
    {
        $data = $request->validate([
            'academic_year'=>'required|string',
            'exam_id'=>'required|exists:exams,id',
            'name'=>'required|string',
            'start_date'=>'required|date',
            'end_date'=>'required|date',
            'type'=>'required|string',
            'settings'=>'nullable|array'
        ]);

        $exam_session->update($data);
        return redirect()->route('admin.exam_sessions.index')->with('success','Session mise à jour');
    }

    public function destroy(ExamSession $exam_session)
    {
        $exam_session->delete();
        return redirect()->route('admin.exam_sessions.index')->with('success','Session supprimée');
    }

    // Méthodes custom pour routes
    public function indexForSession(ExamSession $session)
    {
        $candidates = $session->candidats;
        return view('admin.candidates.index', compact('candidates', 'session'));
    }
}
