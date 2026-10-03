<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PvSignature extends Model
{
    use HasFactory;

    protected $fillable = ['exam_session_id','pv_path','signatures','qr_code_path'];

    protected $casts = [
        'signatures' => 'array'
    ];

    public function session()
    {
        return $this->belongsTo(ExamSession::class, 'exam_session_id');
    }
}
