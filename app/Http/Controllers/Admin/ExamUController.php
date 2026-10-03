<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\Centre;
use App\Models\Competency;

class ExamUController extends Controller
{
    /**
     * Afficher le formulaire d'édition d'un examen
     * Peut être utilisé en page complète ou en modal incluse dans show.blade
     */
    public function edit(Exam $exam)
    {
        $centres = Centre::all();
        $competencies = $exam->competencies()->get();
        return view('admin.exams.edit', compact('exam', 'centres', 'competencies'));
    }

    /**
     * Mettre à jour l'examen et ses compétences
     * Redirige toujours vers exam.show
     */
    public function update(Request $request, Exam $exam)
    {
        // Validation de l'examen
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:exams,code,' . $exam->id,
            'description' => 'nullable|string',
            'min_score'   => 'nullable|numeric',
            'meta'        => 'nullable|array',
        ]);

        $exam->update($data);

        // Mettre à jour les compétences si envoyées
        if ($request->has('competencies')) {
            foreach ($request->input('competencies') as $compId => $compData) {
                Competency::updateOrCreate(
                    ['id' => $compId, 'exam_id' => $exam->id],
                    [
                        'code'  => $compData['code'],
                        'title' => $compData['title']
                    ]
                );
            }
        }

        return redirect()->route('admin.exams.show', $exam)
                         ->with('success', 'Examen et compétences mis à jour avec succès.');
    }

    /**
     * Afficher le détail d'un examen avec ses compétences
     */
    public function showM(Exam $exam, ExamSession $exam_session)
    {
        $session = $exam_session;
        $competencies = $exam_session->exam->competencies()->get(); // Récupère les compétences de l'examen lié

        return view('admin.exam_sessions.showM', compact('exam_session', 'exam', 'session', 'competencies'));
    }

}
