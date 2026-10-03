<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CcpWeight;

class Competency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'title',
        'description',
        'max_score',    
        'centre_id',
        'exam_id',
        'round',
        'coefficient',
        'group_id',
        'order',
    ];

    // Relations
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function centre()
    {
        return $this->belongsTo(Centre::class);
    }

    public function ccpWeights()
    {
        return $this->hasOne(CcpWeight::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
    public function ccpWeight()
    {
        return $this->hasOne(\App\Models\CcpWeight::class, 'competency_id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

}
