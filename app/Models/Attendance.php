<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'section_id',
        'subject_id',
        'teacher_id',
        'date',
        'status'
    ];
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id'); // Assuming teachers are in the `users` table
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }



    protected $dates = ['date'];
}
