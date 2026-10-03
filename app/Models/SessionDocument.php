<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionDocument extends Model
{
    protected $fillable = [
        'exam_session_id',
        'title',
        'file_path',
    ];

    public function session()
    {
        return $this->belongsTo(ExamSession::class, 'exam_session_id');
    }
}
