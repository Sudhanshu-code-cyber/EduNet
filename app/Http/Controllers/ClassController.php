<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
class ClassController extends Controller
{
    public function index() {
    $classes = ClassModel::all();
    return view('page.admin.classes.index', compact('classes'));
}

public function store(Request $request) {
    $request->validate(['name' => 'required|string']);
    ClassModel::create($request->only('name'));
    return redirect()->back()->with('success', 'Class added!');
}

public function update(Request $request, $id) {
    $class = ClassModel::findOrFail($id);
    $class->update($request->only('name'));
    return redirect()->back()->with('success', 'Class added!');
}

public function destroy($id) {
    ClassModel::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'Class added!');
}

}
