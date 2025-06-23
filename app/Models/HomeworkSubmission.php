<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeworkSubmission extends Model
{
    
    protected $fillable = [
        'homework_id',
        'student_id',
        'submitted_file',
        'title',
        'remarks',
        'submitted_date',
        'status',
    ];

public function student()
{
    return $this->belongsTo(Student::class);
}

public function homework()
{
    return $this->belongsTo(Homework::class);
}
}
