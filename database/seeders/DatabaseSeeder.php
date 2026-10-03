<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Centre;
use App\Models\Exam;
use App\Models\Competency;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // -----------------------------
        // 1️⃣ Roles
        // -----------------------------
        $roles = [
            'super-admin',
            'ministere',
            'regional-admin',
            'centre-admin',
            'jury',
            'secretaire',
            'lecteur',
            'etudiant'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // -----------------------------
        // 2️⃣ Centre pilote
        // -----------------------------
        $centre = Centre::firstOrCreate(
            ['code' => 'THI-001'],
            [
                'name' => 'Centre Pilote Thiès',
                'region' => 'Thiès',
                'contact_email' => 'pilote@centre.sn',
                'contact_phone' => '+221 33 000 0000',
                'active' => true
            ]
        );

        $centre2 = Centre::firstOrCreate(
            ['code' => 'DK-002'],
            [
                'name' => 'Centre Pilote Dakar',
                'region' => 'Thiès',
                'contact_email' => 'pilotedk@centre.sn',
                'contact_phone' => '+221 33 300 0000',
                'active' => true
            ]
        );

        // -----------------------------
        // 3️⃣ Exam + Competencies
        // -----------------------------
        $exam = Exam::firstOrCreate(
            ['code' => 'DAP-ELEC-2025'],
            [
                'title' => 'DAP - Électricien',
                'description' => 'Diplôme d’aptitude professionnelle - Électricien',
                'min_score' => 50
            ]
        );

        Competency::firstOrCreate([
            'exam_id' => $exam->id,
            'title' => 'Installation domestique',
            'max_score' => 50
        ]);

        Competency::firstOrCreate([
            'exam_id' => $exam->id,
            'title' => 'Sécurité et réglementation',
            'max_score' => 25
        ]);

        Competency::firstOrCreate([
            'exam_id' => $exam->id,
            'title' => 'Lecture de plans',
            'max_score' => 25
        ]);

        // -----------------------------
        // 4️⃣ Utilisateurs exemple
        // -----------------------------
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@maladho.com',
                'password' => Hash::make('password'),
                'role' => 'super-admin'
            ],
            [
                'name' => 'Ministère',
                'email' => 'ministere@maladho.com',
                'password' => Hash::make('password'),
                'role' => 'ministere'
            ],
            [
                'name' => 'Admin Centre',
                'email' => 'centreadmin@maladho.com',
                'password' => Hash::make('password'),
                'centre_id' => $centre->id,
                'role' => 'centre-admin'
            ],
            [
                'name' => 'Admin Centr 2',
                'email' => 'centreadmin2@maladho.com',
                'password' => Hash::make('password'),
                'centre_id' => $centre2->id,
                'role' => 'centre-admin'
            ],
            [
                'name' => 'Jury',
                'email' => 'jury@maladho.com',
                'password' => Hash::make('password'),
                'centre_id' => $centre->id,
                'role' => 'jury'
            ],
            [
                'name' => 'Secrétaire',
                'email' => 'secretaire@maladho.com',
                'password' => Hash::make('password'),
                'centre_id' => $centre->id,
                'role' => 'secretaire'
            ],
            [
                'name' => 'Lecteur',
                'email' => 'lecteur@maladho.com',
                'password' => Hash::make('password'),
                'centre_id' => $centre->id,
                'role' => 'lecteur'
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                $data
            );
            $user->assignRole($data['role']);
        }

        $this->call([
            ExamSeeder::class,
            RolesAndPermissionsSeeder::class,
            ExamSessionSeeder::class,
            // CompetencySeeder::class,
            // CandidateSeeder::class,
            // ExamsAndCandidateSeeder::class,
            GroupSeeder::class
        ]);
    }
}
