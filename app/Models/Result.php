<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['exam_session_id','candidate_id','total_score','decision','mention','breakdown'];

    protected $casts = [
        'breakdown' => 'array'
    ];

    public function session()
    {
        return $this->belongsTo(ExamSession::class, 'exam_session_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
