<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centre extends Model
{
    use HasFactory;

    protected $fillable = ['code','name','region','address','contact_email','contact_phone','active'];

    // Relations
    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'centre_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function examSessions()
{
    return $this->hasMany(ExamSession::class);
}

}
