<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeeType; 

class FeeTypeController extends Controller
{
    public function index() {
        return view('page.admin.fee.fee-type', [
            'feeTypes' => FeeType::all()
        ]);
    }
    
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'frequency' => 'required|in:monthly,one_time'
        ]);
        FeeType::create($request->only('name', 'frequency'));
        return back()->with('success', 'Fee Type Added');
    }

    public function edit($id)
{
    $feeType = FeeType::findOrFail($id);
    return view('fee-types.edit', compact('feeType'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'frequency' => 'required|in:monthly,one_time'
    ]);

    $feeType = FeeType::findOrFail($id);
    $feeType->update($request->only('name', 'frequency'));

    return redirect()->route('fee-types.index')->with('success', 'Fee Type Updated');
}

public function destroy($id)
{
    FeeType::findOrFail($id)->delete();
    return redirect()->route('fee-types.index')->with('success', 'Fee Type Deleted');
}

    
}
