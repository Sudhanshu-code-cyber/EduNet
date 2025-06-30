<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
      public function index()
    {
        $periods = Period::orderBy('period_number')->get();
        return view('page.admin.periods.index', compact('periods'));
    }

     public function create()
    {
        return view('page.admin.periods.create');
    }

     public function store(Request $request)
    {
        $request->validate([
            'period_number' => 'required|integer',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        Period::create($request->all());

        return redirect()->route('periods.index')->with('success', 'Period created successfully!');
    }

    public function edit($id)
    {
        $period = Period::findOrFail($id);
        return view('page.admin.periods.edit', compact('period'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'period_number' => 'required|integer',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);
        $period = Period::findOrFail($id);
        $period->update($request->all());
        return redirect()->route('periods.index')->with('success', 'Period updated successfully!');
    }

    public function destroy($id)
    {
        $period = Period::findOrFail($id);
        $period->delete();
        return redirect()->route('periods.index')->with('success', 'Period deleted successfully!');
    }
}


