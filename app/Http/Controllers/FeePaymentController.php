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
    $request->validate([
        'class_id' => 'required|exists:classes,id',
        'section_id' => 'required|exists:sections,id',
        'roll_no' => 'required'
    ]);

    $student = Student::where([
        ['class_id', $request->class_id],
        ['section_id', $request->section_id],
        ['roll_no', $request->roll_no],
    ])->first();

    if (!$student) {
        return back()->with('error', 'Student not found.')->withInput();
    }

    $fees = FeeStructure::with('feeType')
        ->where('class_id', $student->class_id)
        ->get();

   $paidData = FeePayment::where('student_id', $student->id)
    ->get()
    ->groupBy('fee_type_id')
    ->map(function ($items) {
        return $items->flatMap(function ($item) {
            return is_array($item->months) ? $item->months : json_decode($item->months, true);
        })
        ->map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT))
        ->unique()
        ->values()
        ->all();
    })
    ->toArray(); 


    $classes = ClassModel::all();
    $sections = Section::all();

    return view('page.admin.fee.fee-payment', compact(
        'student', 'fees', 'classes', 'sections', 'paidData'
    ));
}

    public function store(Request $request)
    {
        $request->validate([
            'fees' => 'required|array',
            'student_id' => 'required|exists:students,id',
            'payment_method' => 'required|string',
        ]);

        $totalPaid = 0;

        foreach ($request->fees as $fee) {
            if (!isset($fee['selected']) || empty($fee['months'])) {
                continue;
            }

            // Save single entry with all selected months
            FeePayment::create([
                'student_id'     => $request->student_id,
                'fee_type_id'    => $fee['fee_type_id'],
                'amount'         => $fee['amount'] * count($fee['months']),
                'months'         => $fee['months'], // Casts to JSON
                'payment_method' => $request->payment_method,
                'status'         => 'Paid',
                'payment_date'   => now(),
            ]);

            $totalPaid += $fee['amount'] * count($fee['months']);
        }

        // Update student status
        $student = Student::find($request->student_id);
        $requiredFees = FeeStructure::where('class_id', $student->class_id)->count();
        $paidFees = FeePayment::where('student_id', $student->id)->distinct('fee_type_id')->count('fee_type_id');

        $student->status = ($paidFees >= $requiredFees) ? 'Active' : 'Inactive';
        $student->save();

      return redirect()->route('fee-payment.create')->with('success', 'Payment recorded. Total Paid: ₹' . $totalPaid);
    }

    public function showFeeDetails(Request $request, $student_id)
    {
        $student = Student::with(['class', 'section'])->findOrFail($student_id);

        $feeStructures = FeeStructure::with('feeType')
            ->where('class_id', $student->class_id)
            ->get();

        $query = FeePayment::where('student_id', $student->id);

        if ($request->year) {
            $query->whereYear('payment_date', $request->year);
        }

        if ($request->month) {
            $query->whereJsonContains('months', str_pad($request->month, 2, '0', STR_PAD_LEFT));
        }

        $paidFees = $query->with('feeType')->get();

        // Group by fee_type_id + months
        $groupedPaid = $paidFees->groupBy(function ($item) {
            return $item->fee_type_id;
        });

       $paidData = $paidFees->groupBy('fee_type_id')->map(function ($items) {
    return $items->flatMap(function ($item) {
        return is_array($item->months) ? $item->months : json_decode($item->months, true);
    })->map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT))
      ->unique()
      ->values()
      ->all();
})->toArray();

return view('page.admin.fee.fee-payment-view', compact(
    'student', 'feeStructures', 'groupedPaid', 'paidFees', 'paidData'
));

    }

    public function storeFeePayment(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fees' => 'required|array',
            'payment_method' => 'required|string',
        ]);

        $total = 0;

        foreach ($request->fees as $fee) {
            if (empty($fee['months'])) continue;

            FeePayment::create([
                'student_id'     => $request->student_id,
                'fee_type_id'    => $fee['fee_type_id'],
                'amount'         => $fee['amount'] * count($fee['months']),
                'months'         => $fee['months'],
                'payment_method' => $request->payment_method,
                'status'         => 'Paid',
                'payment_date'   => now(),
            ]);

            $total += $fee['amount'] * count($fee['months']);
        }

        return back()->with('success', 'Payment recorded. Total Paid: ₹' . $total);
    }

    public function paymentHistory(Request $request)
    {
        $classes = ClassModel::all();
        $sections = Section::all();

        $query = FeePayment::with(['student.class', 'student.section', 'feeType']);

        if ($request->year) {
            $query->whereYear('payment_date', $request->year);
        }

        if ($request->month) {
            $query->whereJsonContains('months', str_pad($request->month, 2, '0', STR_PAD_LEFT));
        }

        if ($request->class_id) {
            $query->whereHas('student', fn ($q) => $q->where('class_id', $request->class_id));
        }

        if ($request->section_id) {
            $query->whereHas('student', fn ($q) => $q->where('section_id', $request->section_id));
        }

        if ($request->roll_no) {
            $query->whereHas('student', fn ($q) => $q->where('roll_no', $request->roll_no));
        }

        $payments = $query->latest()->get();

        return view('page.admin.fee.fee-payment-history', compact('payments', 'classes', 'sections'));
    }
    
}
