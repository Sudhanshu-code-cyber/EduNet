<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ClassModel;
use App\Models\feeTypeModel;

class FeeStructure extends Model
{
    protected $fillable = [
        'class_id', 'fee_type_id', 'amount', 'frequency',
        'start_month', 'is_recurring', 'notes'
    ];
    public function class() {
        return $this->belongsTo(ClassModel::class);
    }
    public function feeType() {
        return $this->belongsTo(FeeType::class);
    }
    protected $casts = [
        'is_recurring' => 'boolean',
    ];
    
}
