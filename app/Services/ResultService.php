<?php

namespace App\Services;

use App\Models\ExamSession;
use App\Models\Score;
use App\Models\Competency;
use App\Models\Result;

class ResultService
{
    /**
     * Construit toutes les données pour le PV (affichage)
     */
    public function buildPvData(ExamSession $session1, ExamSession $session2 = null)
    {
        $exam = $session1->exam;
        $competencies = $exam->competencies()->orderBy('order')->get();

        $scores = Score::whereIn('exam_session_id', [$session1->id, optional($session2)->id])
            ->with(['competency', 'candidate'])
            ->get()
            ->groupBy('candidate_id');

        $pv = [];

        foreach ($scores as $candidateId => $candidateScores) {

            $candidate = $candidateScores->first()->candidate;

            $groupsTotals = [];
            $scoresByCode = [];

            $totalGeneral = 0;
            $totalCoeffGeneral = 0;

            foreach ($candidateScores as $score) {

                $code = $score->competency->code;
                $groupe = $score->competency->group;
                $coef = $score->competency->coefficient;

                $scoresByCode[$code] = $score->score;
                $pondered = $score->score * $coef;

                // Totaux par groupe
                if (!isset($groupsTotals[$groupe])) {
                    $groupsTotals[$groupe] = ['total' => 0, 'coef' => 0];
                }

                $groupsTotals[$groupe]['total'] += $pondered;
                $groupsTotals[$groupe]['coef']  += $coef;

                // Totaux généraux
                $totalGeneral      += $pondered;
                $totalCoeffGeneral += $coef;
            }

            // Moyenne générale
            $moyenne = $totalCoeffGeneral > 0 ? round($totalGeneral / $totalCoeffGeneral, 2) : 0;

            $pv[] = [
                'candidate' => $candidate,
                'scores'    => $scoresByCode,
                'groups'    => $this->calculateGroupsAverages($groupsTotals),
                'total_general' => $totalGeneral,
                'moyenne_generale' => $moyenne,
                'decision' => $moyenne >= $exam->min_score ? 'ADMIS' : 'REFUSE',
                'mention'  => $this->getMention($moyenne),
            ];
        }

        return $pv;
    }


    /**
     * Prépare les colonnes dynamiques du tableau
     */
    public function buildDynamicColumns($exam, $session2)
    {
        return $exam->competencies()
            ->orderBy('order')
            ->get()
            ->groupBy('group')
            ->map(function ($groupCompetencies, $groupName) {
                return [
                    'title' => $groupName,
                    'data'  => $groupCompetencies,
                    'total_key' => "total_{$groupName}",
                    'moyenne_key' => "moyenne_{$groupName}",
                ];
            });
    }


    /**
     * Calcule les moyennes des groupes
     */
    private function calculateGroupsAverages($groupTotals)
    {
        $result = [];

        foreach ($groupTotals as $name => $values) {
            $m = $values['coef'] > 0 ? round($values['total'] / $values['coef'], 2) : 0;

            $result[$name] = [
                'total' => $values['total'],
                'moyenne' => $m,
            ];
        }

        return $result;
    }


    /**
     * Déterminer la mention
     */
    private function getMention($moyenne)
    {
        return match (true) {
            $moyenne >= 16 => 'TRÈS BIEN',
            $moyenne >= 14 => 'BIEN',
            $moyenne >= 12 => 'ASSEZ BIEN',
            $moyenne >= 10 => 'PASSABLE',
            default        => 'INSUFFISANT',
        };
    }


    /**
     * Recalcul complet + sauvegarde en DB
     */
    public function recalculateAndSave(ExamSession $session1, ExamSession $session2 = null)
    {
        $pv = $this->buildPvData($session1, $session2);

        Result::whereIn('exam_session_id', [
            $session1->id,
            optional($session2)->id
        ])->delete();

        foreach ($pv as $row) {
            Result::create([
                'exam_session_id' => $session1->id,
                'candidate_id' => $row['candidate']->id,
                'total_score' => $row['moyenne_generale'],
                'decision' => $row['decision'],
                'mention' => $row['mention'],
                'breakdown' => $row,
            ]);
        }
    }


    /**
     * Statistiques (total / garçons / filles)
     */
    public function getStats($pvData)
    {
        return [
            'total' => count($pvData),
            'boys'  => collect($pvData)->filter(fn($d) => $d['candidate']->sex === 'M')->count(),
            'girls' => collect($pvData)->filter(fn($d) => $d['candidate']->sex === 'F')->count(),
        ];
    }
}
