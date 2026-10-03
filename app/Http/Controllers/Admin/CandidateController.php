<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Centre;
use App\Models\Exam;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CandidatesExport;
use App\Imports\CandidatesImport;

class CandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Liste globale des candidats
     */
    public function index()
    {
        $candidates = Candidate::with(['exam', 'examSession', 'centre'])
            ->get();

        return view('admin.candidates.index', compact('candidates'));
    }

    /**
     * Formulaire création candidat
     */
    public function create(Centre $centre = null)
    {
        $data = [
            'exams' => Exam::all(),
            'sessions' => ExamSession::all(),
            'centres' => Centre::all(),
        ];

        if ($centre) {
            $data['centre'] = $centre;
        }

        return view('admin.candidates.create', $data);
    }

    /**
     * Stocke un candidat (global ou pour un centre)
     */
  public function store(Request $request, Centre $centre = null)
{
    // 1️⃣ Validation des données
    $validated = $request->validate([
        'first_name'        => 'required|string|max:255',
        'last_name'         => 'required|string|max:255',
        'sex'               => 'nullable|in:M,F',
        'birthdate'         => 'nullable|date',
        'birth_place'       => 'nullable|string|max:255',
        'tel'               => 'nullable|string|max:50',
        'national_id'       => 'nullable|string|max:100',

        'ano_number'        => 'nullable|string|max:100',
        'ano_number_2'      => 'nullable|string|max:100',
        'n_base'            => 'nullable|string|max:100',
        'provenance'        => 'nullable|string|max:255',

        'centre_id'         => 'required|exists:centres,id',
        'exam_id'           => 'required|exists:exams,id',
        'exam_session_id'   => 'required|exists:exam_sessions,id',

        'student_id'        => 'nullable|exists:users,id',
        'status'            => 'required|in:inscrit,admis,ajourné,absent',
    ]);

    // 2️⃣ Gestion du centre si passé en paramètre
    $validated['centre_id'] = $centre ? $centre->id : $validated['centre_id'];

    // 3️⃣ Génération automatique de registration_number unique
    if (empty($validated['registration_number'])) {
        $validated['registration_number'] = $this->generateUniqueRegistrationNumber($validated);
    }

    // 4️⃣ Tentative d'enregistrement avec try/catch
    try {
        $candidate = Candidate::create($validated);
    } catch (\Exception $e) {
        return back()->withInput()->with('error', "Erreur lors de l'enregistrement : " . $e->getMessage());
    }

    // 5️⃣ Redirection après succès
    $redirect = $centre 
        ? route('admin.centres.show', $centre->id)
        : route('admin.candidates.index');

    return redirect($redirect)
        ->with('success', '✅ Candidat ajouté avec succès.');
}

/**
 * Génère un registration_number unique
 */
protected function generateUniqueRegistrationNumber(array $data): string
{
    do {
        $number = 'REG-' . strtoupper(substr($data['last_name'], 0, 3)) . rand(1000, 9999);
    } while (Candidate::where('registration_number', $number)->exists());

    return $number;
}


    /**
     * Formulaire édition
     */
    public function edit(Candidate $candidate)
    {
        return view('admin.candidates.edit', [
            'candidate' => $candidate,
            'exams' => Exam::all(),
            'sessions' => ExamSession::all(),
            'centres' => Centre::all(),
        ]);
    }

    /**
     * Mise à jour d’un candidat
     */
    public function update(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'sex'             => 'nullable|in:M,F',
            'birthdate'       => 'nullable|date',
            'tel'             => 'nullable|string|max:20',
            'national_id'     => 'nullable|string|max:50',
            'centre_id'       => 'required|exists:centres,id',
            'exam_id'         => 'required|exists:exams,id',
            'exam_session_id' => 'required|exists:exam_sessions,id',
            'status'          => 'nullable|in:inscrit,admis,ajourné,absent',
        ]);


        // Recalculer le numéro si examen/session/centre change
        $recalculate = $candidate->centre_id != $validated['centre_id']
            || $candidate->exam_id != $validated['exam_id']
            || $candidate->exam_session_id != $validated['exam_session_id'];

        if ($recalculate) {
            $validated = $this->generateRegistrationNumber($validated, $candidate->id);
        }

        $candidate->update($validated);

        return redirect()->route('admin.candidates.index')
            ->with('success', '✅ Candidat mis à jour avec succès.');
    }

    /**
     * Supprimer un candidat
     */
    public function destroy(Candidate $candidate)
    {
        $candidate->delete();

        return redirect()->back()
            ->with('success', '🗑️ Candidat supprimé avec succès.');
    }

    /**
     * Génération du numéro d’inscription
     */
    private function generateRegistrationNumber(array $data, $excludeId = null)
    {
        $centre = Centre::findOrFail($data['centre_id']);
        $exam = Exam::findOrFail($data['exam_id']);
        $session = ExamSession::findOrFail($data['exam_session_id']);

        $centreCode = strtoupper($centre->code ?? $centre->id);
        $examCode = strtoupper($exam->code ?? $exam->id);
        $sessionCode = strtoupper($session->code ?? $session->id);

        $count = Candidate::where('centre_id', $centre->id)
            ->where('exam_id', $exam->id)
            ->where('exam_session_id', $session->id)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->count() + 1;

        $data['registration_number'] = $centreCode . '-' . $examCode . '-' . $sessionCode . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        return $data;
    }

    /**
     * Import Excel
     */
    public function import(Request $request, Centre $centre)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        Excel::import(new CandidatesImport($centre->id), $request->file('file'));

        return redirect()->route('admin.centres.show', $centre->id)
            ->with('success', '✅ Importation réussie !');
    }

    /**
     * Export Excel
     */
    public function export(Centre $centre)
    {
        return Excel::download(new CandidatesExport($centre->id), 'candidats_' . $centre->code . '.xlsx');
    }

    /**
     * Mise à jour du statut via Ajax
     */
    public function updateStatus(Request $request, Candidate $candidate)
    {
        $request->validate([
            'status' => 'required|in:inscrit,admis,ajourné,absent'
        ]);

        $candidate->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }
}
