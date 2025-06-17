<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeeStructure; 
use App\Models\FeeType;      
use App\Models\ClassModel;

class FeeStructureController extends Controller
{
    public function create() {
        return view('page.admin.fee.fee-structure', [
            'classes' => ClassModel::all(),
            'feeTypes' => FeeType::all(),
            'feeStructures' => FeeStructure::with('class', 'feeType')->get()
        ]);
    }
    
    public function store(Request $request) {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric',
            'frequency' => 'required|in:monthly,one_time',
            'start_month' => 'required|date',
            'notes' => 'nullable|string'
        ]);
    
        FeeStructure::create([
            'class_id' => $request->class_id,
            'fee_type_id' => $request->fee_type_id,
            'amount' => $request->amount,
            'frequency' => $request->frequency,
            'start_month' => $request->start_month,
            'is_recurring' => $request->has('is_recurring') ? 1 : 0,
            'notes' => $request->notes
        ]);
    
        return back()->with('success', 'Fee Structure Saved');
    }
    
    public function destroy($id) {
        $structure = FeeStructure::findOrFail($id);
        $structure->delete();
        return back()->with('success', 'Fee Structure deleted successfully.');
    }
    
    public function index(Request $request)
{
    $classes = ClassModel::all();
    $feeTypes = FeeType::all();

    $feeStructures = FeeStructure::with(['class', 'feeType'])
        ->when($request->search_class, function ($query, $classId) {
            $query->where('class_id', $classId);
        })
        ->when($request->search_fee_type, function ($query, $typeId) {
            $query->where('fee_type_id', $typeId);
        })
        ->get();

        return view('page.admin.fee.fee-structure', compact('feeStructures', 'classes', 'feeTypes'));

}

}
