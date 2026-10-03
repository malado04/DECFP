<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year', 
        'exam_id', 
        'centre_id', 
        'name', 
        'start_date', 
        'end_date', 
        'type', 
        'settings'
    ];

    protected $casts = [
        'settings' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];
    public function allScores()
    {
        return $this->hasManyThrough(Score::class, Candidate::class, 'exam_session_id', 'candidate_id', 'id', 'id');
    }

    // 🔗 Relation correcte avec les candidats
    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'exam_session_id');
    }

    // 🔗 Centre
    public function centre()
    {
        return $this->belongsTo(Centre::class, 'centre_id');
    }

    // 🔗 Examen
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    // 🔗 Scores
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    // 🔗 Résultats
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    // 🔗 Signatures de PV
    public function pvSignatures()
    {
        return $this->hasMany(PvSignature::class);
    }
      /**
     * Relation : une session possède plusieurs documents
     */
    public function documents()
    {
        return $this->hasMany(SessionDocument::class, 'exam_session_id');
    }

    public function scopeForUser($query, $user)
    {
        if ($user->hasRole('super-admin') || $user->hasRole('ministere')) {
            return $query;
        }

        if ($user->hasRole('centre-admin')) {
            return $query->whereHas('sessions', function ($q) use ($user) {
                $q->where('centre_id', $user->centre_id);
            });
        }

        return $query->whereRaw('1 = 0');
    }


}
