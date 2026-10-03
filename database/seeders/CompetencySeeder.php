<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Competency;
use App\Models\Exam;
use App\Models\Group;

class CompetencySeeder extends Seeder
{
    public function run(): void
    {
        $exams = Exam::all();

        foreach ($exams as $exam) {

            if (!$exam->centre_id) {
                continue; // sécurité
            }

            $defaultGroup = Group::where('exam_id', $exam->id)
                ->where('name', 'Groupe Général')
                ->first();

            $competency = Competency::create([
                'exam_id'     => $exam->id,
                'centre_id' => $exam->centre_id ?? 1, // 🔥 fallback
                'group_id'    => $defaultGroup?->id,
                'title'       => 'Compétence pour ' . $exam->title,
                'description' => "Description de la compétence pour l'examen {$exam->title}",
                'max_score'   => 100,
                'coefficient' => 1,
                'order'       => 1,
            ]);

            $competency->update([
                'code' => 'COMP-' . str_pad($competency->id, 3, '0', STR_PAD_LEFT),
            ]);
        }

    }
}
