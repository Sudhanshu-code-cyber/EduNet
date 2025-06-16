<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['class_id', 'name', 'code'];

    public function class()
    {
        return $this->belongsTo(ClassModel::class); // Replace with actual model if different
    }

}
