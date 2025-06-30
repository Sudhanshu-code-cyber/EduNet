<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class AssignedTeacher extends Model
{
    use HasFactory;

    protected $table = 'assigned_teachers'; 
    protected $fillable = ['class_id', 'section_id', 'subject_id', 'teacher_id'];

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
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

   

        
}


