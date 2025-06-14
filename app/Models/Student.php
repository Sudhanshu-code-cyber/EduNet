<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'class',
        'section',
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

}
