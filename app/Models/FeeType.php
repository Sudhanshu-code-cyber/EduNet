<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    protected $fillable = ['name', 'frequency'];
    public function feeStructures() {
        return $this->hasMany(FeeStructure::class);
    }
}
