<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    public function run()
    {
        $exams = Exam::all();

        foreach ($exams as $exam) {

            $groupsData = [
                ['name' => 'Groupe Général'],
                ['name' => 'Groupe Théorique'],
                ['name' => 'Groupe Pratique'],
            ];

            foreach ($groupsData as $index => $data) {

                $group = Group::create([
                    'exam_id' => $exam->id,                
                    'centre_id' => $exam->centre_id ?? 1, // 🔥 fallback
                    'name'    => $data['name'],
                    'order'   => $index + 1,
                ]);

                $group->update([
                    'code' => "GRP-" . str_pad($group->id, 3, '0', STR_PAD_LEFT),
                ]);
            }
        }
    }
}
