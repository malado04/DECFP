<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Centre;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\Candidate;
use App\Models\User;

class ExamCentreCandidateSeeder extends Seeder
{
    public function run(): void
    {
        $faker = fake();

        /* ==========================
         | 1. CENTRES
         ========================== */
        $centres = Centre::all();
        if ($centres->isEmpty()) {
            $centre = Centre::create([
                'name' => 'Centre Principal',
                'code' => 'CTR-01',
            ]);
            $centres = collect([$centre]);
        }

        /* ==========================
         | 2. EXAMENS
         ========================== */
        $exam = Exam::firstOrCreate(
            ['code' => 'EXM-2025'],
            [
                'title' => 'Examen National 2025',
                'description' => 'Seed complet examen + candidats',
                'min_score' => 10,
            ]
        );

        /* ==========================
         | 3. JURYS
         ========================== */
        $jurys = User::where('role', 'jury')->get();

        /* ==========================
         | 4. SESSIONS + CANDIDATS
         ========================== */
        foreach ($centres as $centre) {

            // 5 sessions par centre
            for ($s = 1; $s <= 5; $s++) {

                $session = ExamSession::firstOrCreate(
                    [
                        'centre_id'     => $centre->id,
                        'exam_id'       => $exam->id,
                        'academic_year' => '2024-2025',
                        'type'          => 'initial',
                        'name'          => 'Session ' . $s,
                    ],
                    [
                        'start_date' => Carbon::create(2025, 1, 1)->addMonths(($s - 1) * 2),
                        'end_date'   => Carbon::create(2025, 1, 1)->addMonths(($s - 1) * 2 + 1),
                    ]
                );

                /* ==========================
                 | 5. CANDIDATS (20 / session)
                 ========================== */
                for ($i = 1; $i <= 20; $i++) {

                    $candidate = Candidate::create([
                        'ano_number' => strtoupper(Str::random(8)),
                        'registration_number' => 'REG-' . rand(10000, 99999),
                        'n_base' => rand(100000, 999999),

                        'first_name' => $faker->firstName(),
                        'last_name'  => $faker->lastName(),
                        'sex'        => $faker->randomElement(['M','F']),
                        'birthdate'  => Carbon::now()->subYears(rand(18, 30)),
                        'birth_place'=> 'Dakar',
                        'national_id'=> rand(1000000000000, 9999999999999),

                        'tel'     => '77' . rand(1000000, 9999999),
                        'adresse' => 'Sénégal',
                        'provenance' => 'Lycée',

                        'centre_id'       => $centre->id,
                        'exam_id'         => $exam->id,
                        'exam_session_id' => $session->id,
                        'jury_id' => $jurys->where('centre_id', $centre->id)->random()?->id,

                        // 🔑 STATUS COMPATIBLE DB
                        'status' => collect(['present','absent','ajourne'])->random(),
                    ]);

                    /* ==========================
                     | 6. RESULT (simple)
                     ========================== */
                    DB::table('results')->insert([
                        'candidate_id' => $candidate->id,
                        'exam_session_id' => $session->id,
                        'total_score' => rand(6, 18),
                        'decision' => rand(0,1) ? 'admis' : 'ajourne',
                        'mention' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        $this->command->info('✅ Seed fusionné terminé : centres, examens, sessions, candidats, résultats');
    }
}
