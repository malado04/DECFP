<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        // ANO / Identifiants
        'ano_number',
        'ano_number_2',
        'registration_number',
        'n_base',

        // Identité
        'first_name',
        'last_name',
        'sex',
        'birthdate',
        'birth_place',
        'national_id',

        // Contact
        'tel',
        'adresse',

        // Historique
        'admission_2016',
        'provenance',

        // Relations
        'student_id',
        'centre_id',
        'jury_id',
        'exam_id',
        'exam_session_id',

        // Statut
        'status',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'admission_2016' => 'boolean',
    ];

    /* =======================
     | Relations
     ======================= */

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function jury()
    {
        return $this->belongsTo(User::class, 'jury_id');
    }

    public function centre()
    {
        return $this->belongsTo(Centre::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function examSession()
    {
        return $this->belongsTo(ExamSession::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'candidate_id');
    }

    public function documents()
    {
        return $this->hasMany(CandidateDocument::class, 'candidate_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'candidate_id');
    }

    /* =======================
     | Accessors
     ======================= */

    public function getFullNameAttribute(): string
    {
        return strtoupper($this->last_name) . ' ' . ucfirst($this->first_name);
    }

    public function getSexLabelAttribute(): string
    {
        return $this->sex === 'M' ? 'Masculin' : 'Féminin';
    }

    public function getAdmission2016LabelAttribute(): string
    {
        return $this->admission_2016 ? 'OUI' : 'NON';
    }

    /* =======================
     | Logique métier
     ======================= */

    public function calculateFinalAverage($sessionId): ?float
    {
        $scores = $this->scores()
            ->where('exam_session_id', $sessionId)
            ->with('competency')
            ->get();

        $total = 0;
        $coefSum = 0;

        foreach ($scores as $score) {
            if ($score->score !== null) {
                $total += $score->score * $score->competency->coefficient;
                $coefSum += $score->competency->coefficient;
            }
        }

        return $coefSum === 0 ? null : round($total / $coefSum, 2);
    }

    public function getStatusForSession($sessionId): string
    {
        $avg = $this->calculateFinalAverage($sessionId);

        if ($avg === null) {
            return '—';
        }

        $min = $this->examSession?->exam?->min_score;

        return $avg >= $min ? 'ADMIS' : 'NON ADMIS';
    }
}
