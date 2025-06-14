<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'dob',
        'id_no',
        'blood_group',
        'religion',
        'email',
        'class',
        'section',
        'phone',
        'photo',
        'address',
        'short_bio'
    ];
}
