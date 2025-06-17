<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
   // Option 1: fillable (recommended)
protected $fillable = ['name', 'email', 'contact', 'role', 'password'];

}
