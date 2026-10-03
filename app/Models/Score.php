<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_session_id','candidate_id','competency_id','score','status','entered_by','validated_by','validated_at'
    ];

    protected $casts = [
            'validated_at' => 'datetime',
        ];

    // 🆕 Scope pour regrouper les scores par candidat et les lier à la compétence
    public function scopeForPv($query, $sessionId)
    {
        return $query->where('exam_session_id', $sessionId)
            ->join('competencies', 'scores.competency_id', '=', 'competencies.id')
            ->select(
                'scores.candidate_id',
                'scores.score',
                'competencies.code', // Utiliser le CODE de la compétence (ex: C1, C2...)
                'competencies.group', // Utiliser le GROUP pour les totaux intermédiaires
                'competencies.coefficient' // Utiliser le coefficient pour les calculs
            );
    }
    
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function examSession()
    {
        return $this->belongsTo(ExamSession::class, 'exam_session_id');
    }
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }

    public function enteredBy()
    {
        return $this->belongsTo(User::class, 'entered_by');
    }

    public function validatedBy()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function getWeightedScoreAttribute()
    {
        if (!$this->competency || $this->score === null) {
            return null;
        }

        return round($this->score * $this->competency->coefficient, 2);
    }

}
