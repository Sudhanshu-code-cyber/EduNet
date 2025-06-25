<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
     protected $table = 'classes';
    protected $fillable = ['name'];

    public function subjects()
    {
        return $this->hasMany(Subject::class,'class_id');
    }

    public function feeStructures()
    {
        return $this->hasMany(FeeStructure::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function sections()
{
    return $this->hasMany(Section::class);
}

public function classSubjects()
{
    return $this->hasMany(ClassSubject::class, 'class_id');
}

public function pivotSubjects()
{
    return $this->belongsToMany(Subject::class, 'class_subjects')
                ->withPivot('max_marks', 'pass_marks');
}

}
