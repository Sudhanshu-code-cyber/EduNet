<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    protected $table = 'homework';
    protected $fillable = [
        'teacher_id',
        'class_id',
        'section_id',
        'subject_id',
        'title',
        'content',
        'document',
        'homework_date',
        'submission_date',
    ];

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function class() {
        return $this->belongsTo(ClassModel::class);
    }

    public function section() {
        return $this->belongsTo(Section::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }
    
public function submissions()
{
    return $this->hasMany(HomeworkSubmission::class);
}

}
