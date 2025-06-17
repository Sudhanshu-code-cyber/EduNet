<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
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
    ];

    public function feePayments() {
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

}
