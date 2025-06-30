<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Subject extends Model
{
    protected $fillable = ['class_id', 'name', 'code'];

    public function class()
    {
        return $this->belongsTo(ClassModel::class); // Replace with actual model if different
    }
    public function subject()
{
    return $this->belongsTo(Subject::class, 'subject_id');
}
 public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

}
