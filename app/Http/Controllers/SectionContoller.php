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

public function delete($id){
    Section::where('class_id', $id)->delete();
    return redirect()->route('create.section')->with('error','Student deleted successfully! ');
}

public function update(Request $request, $classId)
{
    // Delete existing sections for this class
    Section::where('class_id', $classId)->delete();

    // Insert new sections
    $sectionNames = explode(',', $request->sections);
    foreach ($sectionNames as $name) {
        Section::create([
            'class_id' => $classId,
            'name' => strtoupper(trim($name)),
        ]);
    }

    return redirect()->route('create.section')->with('success', 'Sections updated!');
}





}
