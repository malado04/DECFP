<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CcpWeight extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id','competency_id','weight'];
    protected $casts = [
        'weight' => 'float',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }
   
}
