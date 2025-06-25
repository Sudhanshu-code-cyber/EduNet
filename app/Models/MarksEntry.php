<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class MarksEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'exam_master_id',
        'subject_id',
        'marks_obtained',
        'teacher_id',
        'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function exam()
    {
        return $this->belongsTo(ExamMaster::class, 'exam_master_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
