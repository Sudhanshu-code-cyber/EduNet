<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\FeeType;
use App\Models\FeePayment;
use App\Models\FeeStructure;
use Illuminate\Http\Request;

class FeePaymentSummaryController extends Controller
{
  public function index()
    {
        $students = Student::with('class', 'section')->get();
        $feeTypes = FeeType::all();

        $initialSummary = [];
        $academicStartMonth = 4; // April
        $currentMonth = (int) date('n');

        foreach ($students as $student) {
            $total = 0;
            $paid = 0;

            $structures = FeeStructure::where('class_id', $student->class_id)
                ->where('frequency', 'monthly')
                ->get();

            $amountMap = $structures->pluck('amount', 'fee_type_id');
            $requiredFeeTypesPerMonth = count($amountMap);

            $payments = FeePayment::where('student_id', $student->id)->get();

          foreach ($amountMap as $monthlyAmount) {
    $total += $monthlyAmount * 12;
}

            $monthPaidCount = [];
            foreach ($payments as $payment) {
                $paid += $payment->amount;
                $m = str_pad($payment->month, 2, '0', STR_PAD_LEFT);
                $monthPaidCount[$m] = ($monthPaidCount[$m] ?? 0) + 1;
            }

            $status = 'Not Paid';
            if ($paid >= $total) {
                $status = 'Fully Paid';
            } elseif ($paid > 0) {
                $status = 'Partially Paid';
            }

            $monthFlags = [];
            foreach (range(1, 12) as $m) {
                $code = str_pad($m, 2, '0', STR_PAD_LEFT);

                if ($m < $academicStartMonth || $m > $currentMonth) {
                    $monthFlags[$code] = 'none';
                } else {
                    $paidCount = $monthPaidCount[$code] ?? 0;
                    $monthFlags[$code] = $paidCount >= $requiredFeeTypesPerMonth ? 'paid' : 'due';
                }
            }

            $initialSummary[$student->id] = [
                'total' => number_format($total, 2),
                'paid' => number_format($paid, 2),
                'due' => number_format(max(0, $total - $paid), 2),
                'status' => $status,
                'months' => $monthFlags
            ];
        }

        return view('page.admin.fee.fee-payment-summary', compact('students', 'feeTypes', 'initialSummary'));
    }

    public function getFeeMonths(Request $request)
    {
        $paidMonths = FeePayment::where('student_id', $request->student_id)
            ->where('fee_type_id', $request->fee_type_id)
            ->pluck('month')
            ->map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT))
            ->toArray();

        return response()->json($paidMonths);
    }

    public function monthsData(Request $request)
    {
        $studentId = $request->student_id;
        $feeTypeId = $request->fee_type_id;

        $student = Student::findOrFail($studentId);
        $structure = FeeStructure::where('class_id', $student->class_id)
            ->where('fee_type_id', $feeTypeId)
            ->first();

        $monthlyAmount = $structure->amount ?? 0;

        $academicStartMonth = 4; // April
        $currentMonth = (int) date('n');

        $monthsTillNow = max(0, $currentMonth - $academicStartMonth + 1);
        $totalAmount = $monthlyAmount * $monthsTillNow;

        $payments = FeePayment::where('student_id', $studentId)
            ->where('fee_type_id', $feeTypeId)
            ->get();

        $paidAmount = $payments->sum('amount');
        $paidMonths = $payments->pluck('month')->map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT))->toArray();
        $paidSet = collect($paidMonths)->unique()->toArray();

        // Determine due months: April to current month minus paid
        $applicableMonths = collect(range($academicStartMonth, $currentMonth))
            ->map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT))
            ->toArray();

        $dueMonths = array_values(array_diff($applicableMonths, $paidSet));

        $status = 'Not Paid';
        if ($paidAmount >= $totalAmount) {
            $status = 'Fully Paid';
        } elseif ($paidAmount > 0) {
            $status = 'Partially Paid';
        }

        return response()->json([
            'paidMonths' => $paidSet,
            'dueMonths' => $dueMonths,
            'paidAmount' => number_format($paidAmount, 2),
            'totalAmount' => number_format($totalAmount, 2),
            'dueAmount' => number_format($totalAmount - $paidAmount, 2),
            'status' => $status
        ]);
    }
}
