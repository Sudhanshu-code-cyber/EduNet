<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    protected $fillable = [
        'student_id', 'fee_type_id', 'amount', 'month', 'payment_method', 'status', 'payment_date',
    ];

    public function feeType() {
        return $this->belongsTo(FeeType::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
