<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function create(){
        return view('page.admin.teacher-section.add-teacher');
    }
}
