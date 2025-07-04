<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'details', 'date', 'expires_at',
        'created_by', 'creator_role', 'target','attachment',
    ];

    public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

}
