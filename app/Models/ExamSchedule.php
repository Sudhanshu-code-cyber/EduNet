<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{

    use HasFactory;
    protected $fillable = [
        'exam_name', 'class_id', 'section_id', 'subject_id',
        'exam_date', 'start_time', 'end_time', 'duration',
        'room_no', 'max_marks', 'min_marks', 'teacher_id'
    ];
public function subject()
{
    return $this->belongsTo(Subject::class);
}

    public function class()    { return $this->belongsTo(ClassModel::class); }
    public function section()  { return $this->belongsTo(Section::class); }
    public function teacher()  { return $this->belongsTo(Teacher::class); }
}
