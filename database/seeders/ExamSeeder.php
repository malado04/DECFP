<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam;
use App\Models\Centre;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les centres
        $centres = Centre::all();

        // S'il n'y a aucun centre, en créer un par défaut
        if ($centres->isEmpty()) {
            $centre = Centre::create([
                'name' => 'Centre Principal',
                'code' => 'CTR-01',
            ]);

            $centres = collect([$centre]);
        }

        $exams = [
            ['code' => 'EXM101', 'title' => 'Mathématiques', 'description' => 'Épreuve de mathématiques générales'],
            ['code' => 'EXM102', 'title' => 'Français', 'description' => 'Maîtrise de la langue française'],
            ['code' => 'EXM103', 'title' => 'Histoire-Géographie', 'description' => 'Culture générale historique'],
            ['code' => 'EXM104', 'title' => 'Sciences Physiques', 'description' => 'Épreuve Physique/Chimie'],
            ['code' => 'EXM105', 'title' => 'Biologie', 'description' => 'Connaissances du vivant'],
            ['code' => 'EXM106', 'title' => 'Comptabilité', 'description' => 'Calculs comptables et bilans'],
            ['code' => 'EXM107', 'title' => 'Informatique', 'description' => 'Algorithmes et bases systèmes'],
            ['code' => 'EXM108', 'title' => 'Anglais', 'description' => 'Expression écrite/orale'],
            ['code' => 'EXM109', 'title' => 'Droit', 'description' => 'Notions fondamentales de législation'],
            ['code' => 'EXM110', 'title' => 'Entrepreneuriat', 'description' => 'Gestion d’entreprise et projet'],
        ];

        foreach ($exams as $index => $exam) {
            Exam::create([
                'code'        => $exam['code'],
                'title'       => $exam['title'],
                'description' => $exam['description'],
                // Répartition sur les centres
                'centre_id'   => $centres[$index % $centres->count()]->id,
            ]);
        }
    }
}
