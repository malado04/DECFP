<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competency;
use Illuminate\Http\Request;

class CompetencyController extends Controller
{
    public function index()
    {
        $competencies = Competency::all();
        return view('admin.competencies.index', compact('competencies'));
    }

    public function create()
    {
        return view('admin.competencies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'exam_id'     => 'required|exists:exams,id',
            'group_id' => 'required|exists:groups,id',
            // 'name'        => 'nullable|string|unique:competencies,name',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_score'   => 'required|numeric|min:0',
            'coefficient' => 'nullable|integer|min:0',
            'order'       => 'nullable|integer|min:0',
        ]);

        // Valeurs par défaut pour certains champs
        $data['coefficient'] = $data['coefficient'] ?? 1;
        $data['order'] = $data['order'] ?? 1;

        // Génération d'un code unique si non fourni
        if (empty($data['code'])) {// Si tu veux que le code inclue l’ID
        $competency = Competency::create($data);
        
         $competency->update([
                'code' => 'COMP-' . str_pad($competency->id, 3, '0', STR_PAD_LEFT)
            ]);
        }


        return redirect()->route('admin.competencies.index')
                         ->with('success', 'Compétence créée avec succès.');
    }

    public function show(Competency $competency)
    {
        return view('admin.competencies.show', compact('competency'));
    }

    public function edit(Competency $competency)
    {
        return view('admin.competencies.edit', compact('competency'));
    }

    public function update(Request $request, Competency $competency)
    {
        $data = $request->validate([
            'exam_id'     => 'required|exists:exams,id',
            'code'        => 'required|string|unique:competencies,code,' . $competency->id,
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_score'   => 'required|numeric|min:0',
            'coefficient' => 'nullable|integer|min:0',
            'group'       => 'nullable|string|max:100',
            'order'       => 'nullable|integer|min:0',
        ]);

        // Valeurs par défaut
        $data['coefficient'] = $data['coefficient'] ?? 1;
        $data['order'] = $data['order'] ?? 1;

        $competency->update($data);

        return redirect()->route('admin.competencies.index')
                         ->with('success', 'Compétence mise à jour avec succès.');
    }

    public function destroy(Competency $competency)
    {
        $competency->delete();

        return redirect()->route('admin.competencies.index')
                         ->with('success', 'Compétence supprimée avec succès.');
    }
}
