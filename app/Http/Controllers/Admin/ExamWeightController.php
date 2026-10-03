<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;       // ← OBLIGATOIRE
use App\Models\Exam;
use App\Models\Competency;
use App\Http\Requests\UpdateWeightRequest;
use App\Services\ExamWeightService;

class ExamWeightController extends Controller
{
    public function update(UpdateWeightRequest $request, Exam $exam, Competency $competency)
    {
        app(ExamWeightService::class)->setWeight(
            $exam,
            $competency,
            $request->weight
        );

        return back()->with('success', 'Poids mis à jour avec succès.');
    }

    public function updateAll(Request $request, Exam $exam)
    {
        $weights = $request->input('weights', []);

        foreach ($weights as $competencyId => $weight) {
            app(ExamWeightService::class)->setWeight(
                $exam,
                Competency::find($competencyId),
                floatval($weight)
            );
        }

        return back()->with('success', 'Pondérations mises à jour avec succès.');
    }
}
