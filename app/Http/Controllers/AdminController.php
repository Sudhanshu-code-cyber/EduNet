<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('page.admin.dashboard');
    }

     public function allstudent(){
        return view('page.admin.student.allstudent');
    }

     public function addstudent(){
        return view('page.admin.student.addstudent');
    }
}
