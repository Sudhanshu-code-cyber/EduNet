<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\FeeStructure;
use App\Models\FeePayment;
use App\Models\ClassModel;
use App\Models\Section;

class FeePaymentController extends Controller
{

    public function create()
    {
        $classes = ClassModel::all();
        $sections = Section::all();

        return view('page.admin.fee.fee-payment', compact('classes', 'sections'));
    }


    public function search(Request $request)
{

    $student = Student::where([
        ['class_id', $request->class_id],
        ['section_id', $request->section_id],
        ['roll', $request->roll],
    ])->first();

    if (!$student) {
        return back()->with('error', 'Student not found.');
    }

    $fees = FeeStructure::with('feeType')
                ->where('class_id', $student->class_id)
                ->get();

    return view('fee_structure.payment', compact('student', 'fees'));
}

public function store(Request $request)
{
    $totalPaid = 0;
    foreach ($request->fees as $fee) {
        if (isset($fee['selected'])) {
            FeePayment::create([
                'student_id' => $request->student_id,
                'fee_type_id' => $fee['fee_type_id'],
                'amount' => $fee['amount'],
                'month' => $fee['month'],
                'payment_method' => $request->payment_method,
                'status' => 'Paid',
                'payment_date' => now(),
            ]);
            $totalPaid += $fee['amount'];
        }
    }

    $student = Student::find($request->student_id);
    $requiredFees = FeeStructure::where('class_id', $student->class_id)->count();
    $paidFees = FeePayment::where('student_id', $student->id)->distinct('fee_type_id')->count('fee_type_id');
    
    $student->status = ($paidFees >= $requiredFees) ? 'Active' : 'Inactive';
    $student->save();

    return back()->with('success', 'Payment recorded. Total Paid: ₹' . $totalPaid);
}

}
