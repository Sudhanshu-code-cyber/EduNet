<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
   protected $fillable = ['class_id', 'name'];


   public function classroom()
{
    return $this->belongsTo(ClassModel::class);
}


}


