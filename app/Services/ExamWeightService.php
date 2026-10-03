<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\Competency;

class ExamWeightService
{
    /**
     * Crée ou met à jour un poids.
     */

    public function setWeight(Exam $exam, Competency $competency, float $weight)
    {
        return $exam->ccpWeights()->updateOrCreate(
            [
                'exam_id'       => $exam->id,
                'competency_id' => $competency->id
            ],
            [
                'weight' => $weight
            ]
        );
    }

    /**
     * Retourne les compétences avec leurs poids.
     */
    public function getWeightedCompetencies(Exam $exam)
    {
        return $exam->competencies()->with('ccpWeight')->orderBy('order')->get();
    }

    /**
     * Exemple de calcul pondéré.
     */
    public function calculateFinalScore($scores)
    {
        return $scores->sum(function ($score) {
            $weight = $score->competency->ccpWeight->weight ?? 1;
            return $score->value * $weight;
        });
    }
}
