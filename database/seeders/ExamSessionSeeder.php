<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExamSession;
use App\Models\Exam;
use Carbon\Carbon;


class ExamSessionSeeder extends Seeder
{
    public function run()
    {
        $year = now()->year;
        $academicYear = $year . '-' . ($year + 1);

        $exams = Exam::all();

        foreach ($exams as $exam) {

            for ($i = 1; $i <= 5; $i++) {

                $startDate = Carbon::create($year, 1, 1)->addMonths(($i - 1) * 2);
                $endDate   = $startDate->copy()->addMonth();

                ExamSession::firstOrCreate(
                    [
                        'exam_id'       => $exam->id,
                        'centre_id'     => 1,
                        'academic_year' => $academicYear,
                        'type'          => 'normale',
                        'name'          => 'Session ' . $i,
                    ],
                    [
                        'start_date' => $startDate,
                        'end_date'   => $endDate,
                    ]
                );
            }
        }
    }
}