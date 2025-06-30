<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherTimetable extends Model
{

    protected $fillable = [
    'teacher_id',
    'class_id',
    'section_id',
    'subject_id',
    'period_id',
    'day_of_week',
];

    public function teacher()
{
    return $this->belongsTo(Teacher::class);
}

public function class()
{
    return $this->belongsTo(ClassModel::class);
}

public function section()
{
    return $this->belongsTo(Section::class);
}

public function subject()
{
    return $this->belongsTo(Subject::class);
}

public function period()
{
    return $this->belongsTo(Period::class);
}



}
