<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CCPWeight;
use App\Models\Exam;
use App\Models\competencies;
use App\Models\ExamSession;
use App\Models\Candidate;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['code','title','description','min_score','meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function competencies()
    {
        return $this->hasMany(Competency::class, 'exam_id');
    }

    public function sessions()
    {
        return $this->hasMany(ExamSession::class, 'exam_id');
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'exam_id');
    }

    public function ccpWeights()
    {
        return $this->hasMany(CcpWeight::class, 'exam_id');
    }
    
    public function competenciesWithWeights()
    {
        return $this->competencies()->with('ccpWeight');
    }

}
