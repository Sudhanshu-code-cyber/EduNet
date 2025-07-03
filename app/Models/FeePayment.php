<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    protected $fillable = [
        'student_id', 'fee_type_id', 'amount', 'months', 'payment_method', 'status', 'payment_date',
    ];

        protected $casts = [
        'months' => 'array',  
        'payment_date' => 'date',
    ];

    public function feeType() {
        return $this->belongsTo(FeeType::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
