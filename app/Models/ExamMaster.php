<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ExamMaster extends Model
{
    use HasFactory;

    protected $fillable =['exam_name', 'exam_date', 'start_time', 'end_time'];

    public function marksEntries()
    {
        return $this->hasMany(MarksEntry::class);
    }

}
