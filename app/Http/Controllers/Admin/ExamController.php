<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Centre;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 🏛️ Ministère & super-admin → tous les examens nationaux
        if ($user->hasRole('super-admin') || $user->hasRole('ministere')) {

            $exams = Exam::withCount('sessions')->get();

        }
        // 🏫 Centre-admin → examens pour lesquels son centre a une session
        elseif ($user->hasRole('centre-admin')) {

            $exams = Exam::whereHas('sessions', function ($q) use ($user) {
                $q->where('centre_id', $user->centre_id);
            })
            ->withCount(['sessions as sessions_count' => function ($q) use ($user) {
                $q->where('centre_id', $user->centre_id);
            }])
            ->get();

        }
        // 🔐 Autres rôles → vide par sécurité
        else {
            $exams = collect();
        }

        return view('admin.exams.index', compact('exams'));
    }



    public function create()
    {
        $centres = Centre::all();
        $exams = Exam::all();
        return view('admin.exams.create', compact('centres', 'exams'));

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'min_score' => 'nullable|numeric',
            'meta' => 'nullable|array',
            // 'centre_id' => 'required|exists:centres,id'
        ]);

        // Générer un code unique du type EXAM-YYYYMMDD-XXX
        $datePart = date('d-m-Y');

        // Compter le nombre d'examens créés aujourd'hui
        $countToday = Exam::whereDate('created_at', now()->toDateString())->count() + 1;

        // Formater le compteur sur 3 chiffres avec des zéros devant
        $counter = str_pad($countToday, 3, '0', STR_PAD_LEFT);

        $data['code'] = 'EXAM-' . $datePart . '-' . $counter;

        Exam::create($data);

        return redirect()->route('admin.exams.index')->with('success', 'Examen créé avec le code ' . $data['code']);
    }

public function show(Exam $exam)
{
    $user = auth()->user();

    // 🗂️ Sessions filtrées selon le rôle
    if ($user->hasRole('super-admin') || $user->hasRole('ministere')) {

        // Toutes les sessions de l’examen
        $sessions = $exam->sessions()
            ->with('centre')
            ->orderBy('academic_year', 'desc')
            ->get();

    } elseif ($user->hasRole('centre-admin')) {

        // Sessions de CET examen pour MON centre
        $sessions = $exam->sessions()
            ->where('centre_id', $user->centre_id)
            ->orderBy('academic_year', 'desc')
            ->get();

    } else {

        // Sécurité : rien
        $sessions = collect();
    }

    // Les compétences sont nationales → pas de filtrage
    $competencies = $exam->competencies()
        ->orderBy('code')
        ->get();

    return view('admin.exams.show', compact('exam', 'sessions', 'competencies'));
}


    public function edit(Exam $exam)
    {
        $centres = Centre::all();
        $exams = Exam::all();
        return view('admin.exams.edit', compact('centres', 'exam'));
        // return view('admin.exams.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $data = $request->validate([
            // 'code'=>'required|string',
            'title'=>'required|string',
            'description'=>'nullable|string',
            'min_score'=>'nullable|numeric',
            'meta'=>'nullable|array'
        ]);

        $exam->update($data);
        return redirect()->route('admin.exams.index')->with('success', 'Examen mis à jour.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')->with('success', 'Examen supprimé.');
    }
}
