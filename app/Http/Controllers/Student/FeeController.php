<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\FeeStructure;
use App\Models\FeePayment;
use Illuminate\Http\Request;

class FeeController extends Controller
{
  public function overview()
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()->route('login')->with('error', 'Please login as student.');
        }

        $student = Student::with('class', 'section')->findOrFail($studentId);

        $feeStructures = FeeStructure::with('feeType')
            ->where('class_id', $student->class_id)
            ->get();

        $payments = FeePayment::where('student_id', $student->id)->get();

        $paymentMap = [];
        $monthPaidMap = [];

        foreach ($payments as $payment) {
            $feeTypeId = $payment->fee_type_id;
            $structure = $feeStructures->firstWhere('fee_type_id', $feeTypeId);
            if (!$structure) continue;

            if ($structure->frequency === 'one_time') {
                $key = $feeTypeId . '_One-Time';
            } else {
                $month = is_numeric($payment->month)
                    ? date('M', mktime(0, 0, 0, (int) $payment->month, 1))
                    : $payment->month;
                $key = $feeTypeId . '_' . $month;
            }

            if (!isset($paymentMap[$key])) {
                $paymentMap[$key] = 0;
            }
            $paymentMap[$key] += (float) $payment->amount;

            $monthPaidMap[$feeTypeId][] = $payment->month;
        }

        return view('page.student.fees.fee-overview', compact('student', 'feeStructures', 'paymentMap', 'monthPaidMap'));
    }

  public function pay(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'fees' => 'required|array',
        'payment_method' => 'required|string',
    ]);

    $studentId = $request->student_id;

    foreach ($request->fees as $fee) {
        if (!isset($fee['months']) || !is_array($fee['months']) || empty($fee['months'])) {
            continue;
        }

        $months = array_map(function ($month) {
            return is_numeric($month) ? str_pad($month, 2, '0', STR_PAD_LEFT) : $month;
        }, $fee['months']);

        FeePayment::create([
            'student_id' => $studentId,
            'fee_type_id' => $fee['fee_type_id'],
            'months' => json_encode($months), 
            'amount' => $fee['amount'] * count($months),
            'payment_method' => $request->payment_method,
            'status' => 'Paid',
            'payment_date' => now(),
        ]);
    }

    return redirect()->route('student.fees.overview')->with('success', 'Payment successful!');
}

  public function payFeesPage(Request $request)
{
    $studentId = session('student_id');
    if (!$studentId) {
        return redirect()->route('login')->with('error', 'Login as student first');
    }

    $student = Student::with('class', 'section')->findOrFail($studentId);
    $feeStructures = FeeStructure::with('feeType')
        ->where('class_id', $student->class_id)
        ->get();

    $payments = FeePayment::where('student_id', $student->id)->get();
    $groupedPaid = [];
foreach ($payments as $payment) {
    $feeTypeId = $payment->fee_type_id;
    $structure = $feeStructures->firstWhere('fee_type_id', $feeTypeId);
    if (!$structure) continue;

    $months = is_array($payment->months)
        ? $payment->months
        : (json_decode($payment->months, true) ?? []);

    foreach ($months as $m) {
        $monthNum = is_numeric($m)
            ? str_pad($m, 2, '0', STR_PAD_LEFT)
            : str_pad(date('m', strtotime($m)), 2, '0', STR_PAD_LEFT);

        $key = $structure->frequency === 'one_time'
            ? $feeTypeId . '_One-Time'
            : $feeTypeId . '-' . $monthNum;

        $groupedPaid[$key] = true;
    }
}
    return view('page.student.fees.pay-fees', compact('student', 'feeStructures', 'groupedPaid'));
}

public function paymentHistory()
{
    $student = auth()->user()->student;

    $payments = \App\Models\FeePayment::with('feeType')
                ->where('student_id', $student->id)
                ->orderBy('payment_date', 'desc')
                ->get();

    return view('page.student.fees.payment-history', compact('student', 'payments'));
}

}

