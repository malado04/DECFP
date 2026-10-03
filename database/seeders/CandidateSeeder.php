<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidate;
use App\Models\Centre;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $centres  = Centre::all();
        $exams    = Exam::all();
        $sessions = ExamSession::all();
        $jurys    = User::where('role', 'jury')->get();

        if ($centres->isEmpty() || $exams->isEmpty() || $sessions->isEmpty()) {
            $this->command->warn('Centres, examens ou sessions manquants.');
            return;
        }

        foreach ($centres as $centre) {

            $centreSessions = $sessions->where('centre_id', $centre->id);

            foreach ($centreSessions as $session) {

                for ($i = 1; $i <= 20; $i++) {

                    $jury = $jurys->where('centre_id', $centre->id)->random();

                    Candidate::create([
                        'ano_number'       => strtoupper(Str::random(8)),
                        'registration_number' => 'REG-' . $faker->unique()->numberBetween(10000, 9999999),
                        'n_base'           => $faker->unique()->numberBetween(100000, 999999),

                        'first_name'       => $faker->firstName(),
                        'last_name'        => $faker->lastName(),
                        'sex'              => rand(0, 1) ? 'M' : 'F',
                        'birthdate'        => Carbon::now()->subYears(rand(18, 30)),
                        'birth_place'      => 'Dakar',
                        'national_id'      => $faker->unique()->numberBetween(1000000000000, 9999999999999),

                        'tel'              => '77' . rand(1000000, 9999999),
                        'adresse'          => 'Sénégal',
                        'provenance'       => 'Lycée',

                        'centre_id'        => $centre->id,
                        'exam_id'          => $session->exam_id,
                        'exam_session_id'  => $session->id,
                        'jury_id'          => $jury ? $jury->id : null,

                        'status'           => collect(['present','absent','ajourne'])->random(),
                    ]);
                }
            }
        }
    }
}
