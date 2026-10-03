<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'exam_id',
        'centre_id', 
        'name',
        'code',
        'order',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function competencies()
    {
        return $this->hasMany(Competency::class);
    }
}
