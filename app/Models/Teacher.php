<?php

namespace App\Models;

use App\Models\AssignedTeacher;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Subject;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'gender',
        'dob',
        'id_no',
        'blood_group',
        'religion',
        'email',
        'qualification', 
        'phone',
        'photo',
        'address',
        'short_bio'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTeachers()
    {
        return $this->hasMany(AssignedTeacher::class, 'teacher_id');
    }

    public function assignedClasses()
    {
        return $this->assignedTeachers()
                    ->with('class')
                    ->get()
                    ->pluck('class')
                    ->unique('id')
                    ->values();
    }

    public function assignedSections()
    {
        return $this->assignedTeachers()
                    ->with('section')
                    ->get()
                    ->pluck('section')
                    ->unique('id')
                    ->values();
    }

    public function assignedSubjects()
    {
        return $this->assignedTeachers()
                    ->with('subject')
                    ->get()
                    ->pluck('subject')
                    ->unique('id')
                    ->values();
    }
    

}
