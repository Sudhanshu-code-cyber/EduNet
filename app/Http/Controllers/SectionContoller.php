<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionContoller extends Controller
{

    
    public function index(){
        $classes=ClassModel::all();
        $groupedSections =Section::all()->groupBy('class_id');
        return view('page.admin.section.section-class',compact('classes','groupedSections'));
    }

    public function storeSections(Request $request)
{
    $request->validate([
        'class' => 'required|numeric', // assuming class_id is integer
        'sections' => 'required|array',
        'sections.*' => 'string',
    ]);

    foreach ($request->sections as $sectionName) {
        Section::create([
            'class_id' => $request->class,   // ✅ This is the key line
            'name' => $sectionName,
        ]);
    }

    return back()->with('success', 'Sections saved successfully!');
}

}
