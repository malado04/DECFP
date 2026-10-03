<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\CcpWeight;
use Illuminate\Http\Request;

class CcpWeightController extends Controller
{
    public function index()
    {
        $weights = CcpWeight::with(['exam','competency'])->get();
        return view('admin.ccp_weights.index', compact('weights'));
    }

    public function create()
    {
        return view('admin.ccp_weights.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'competency_id' => 'required|exists:competencies,id',
            'weight' => 'required|numeric|min:0|max:100',
        ]);

        CcpWeight::create($data);

        return redirect()
            ->route('admin.ccp_weights.index')
            ->with('success', 'Pondération CCP créée');
    }

    public function edit(Exam $exam)
    {
        $competencies = $exam->competencies()->orderBy('order')->get();
        $weights = $exam->ccpWeights->pluck('weight', 'competency_id');

        return view('admin.ccp_weights.edit', compact('exam', 'competencies', 'weights'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'weights.*' => 'required|numeric|min:0|max:100',
        ]);

        $weights = $request->weights;

        if (array_sum($weights) != 100) {
            return back()->with('error', 'La somme des pondérations doit être exactement 100% !');
        }

        foreach ($weights as $competencyId => $weight) {
            CcpWeight::updateOrCreate(
                [
                    'exam_id' => $exam->id,
                    'competency_id' => $competencyId,
                ],
                [
                    'weight' => $weight,
                ]
            );
        }

        return back()->with('success', 'Pondérations mises à jour avec succès !');
    }

    public function destroy(CcpWeight $ccp_weight)
    {
        $ccp_weight->delete();

        return redirect()
            ->route('admin.ccp_weights.index')
            ->with('success', 'Pondération CCP supprimée');
    }
}
