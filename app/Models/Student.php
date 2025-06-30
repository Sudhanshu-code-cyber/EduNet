<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'full_name',
        'class_id',
        'section_id',
        'gender',
        'dob',
        'roll_no',
        'admission_no',
        'age',
        'blood_group',
        'religion',
        'email',
        'photo',
        'father_name',
        'mother_name',
        'father_occupation',
        'contact',
        'nationality',
        'present_address',
        'permanent_address',
        'parents_photo',
        'transport_id',
        'uses_transport'
    ];

    protected $guarded = [];


    public function feePayments()
    {
        return $this->hasMany(FeePayment::class);
    }


    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }
public function getSubjects()
{
    return Subject::whereIn('id', function ($query) {
        $query->select('subject_id')
            ->from('assigned_teachers')
            ->where('class_id', $this->class_id)
            ->where('section_id', $this->section_id);
    })->get();
}





}



