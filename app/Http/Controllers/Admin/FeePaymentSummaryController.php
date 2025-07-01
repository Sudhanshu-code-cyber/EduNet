<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Section;
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
        $classes = ClassModel::all();
        $sections = Section::all();
        $initialSummary = [];
        $academicStartMonth = 4; // April
        $currentMonth = (int) date('n');

        $classId = request('class_id');
        $sectionId = request('section_id');
        $name = request('name');
        $rollNo = request('roll_no');

        $students = Student::with('class', 'section')
            ->when($classId, fn($q) => $q->where('class_id', $classId))
            ->when($sectionId, fn($q) => $q->where('section_id', $sectionId))
            ->when($name, fn($q) => $q->where('full_name', 'like', "%$name%"))
            ->when($rollNo, fn($q) => $q->where('roll_no', $rollNo))
            ->get();

        foreach ($students as $student) {
            $structures = FeeStructure::where('class_id', $student->class_id)->get();
            $payments = FeePayment::where('student_id', $student->id)->get();

            $total = 0;
            $paid = $payments->sum('amount');
            $monthPaidCount = [];

            foreach ($payments as $payment) {
                $m = str_pad($payment->month, 2, '0', STR_PAD_LEFT);
                $monthPaidCount[$m] = ($monthPaidCount[$m] ?? 0) + 1;
            }

            $amountMap = [];
            $requiredFeeTypesPerMonth = 0;

            foreach ($structures as $structure) {
                if ($structure->frequency === 'monthly') {
                    $amountMap[$structure->fee_type_id] = $structure->amount;
                    $total += $structure->amount * 12;
                } else {
                    $total += $structure->amount; // one_time fee
                }
            }

            $requiredFeeTypesPerMonth = count(array_filter($structures->toArray(), fn($s) => $s['frequency'] === 'monthly'));

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

        return view('page.admin.fee.fee-payment-summary', compact('students', 'feeTypes', 'initialSummary', 'classes', 'sections'));
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

        $payments = FeePayment::where('student_id', $studentId)
            ->where('fee_type_id', $feeTypeId)
            ->get();

        $paidAmount = $payments->sum('amount');

        if ($structure->frequency === 'one_time') {
            return response()->json([
                'paidMonths' => [],
                'dueMonths' => [],
                'paidAmount' => number_format($paidAmount, 2),
                'totalAmount' => number_format($structure->amount, 2),
                'dueAmount' => number_format(max(0, $structure->amount - $paidAmount), 2),
                'status' => $paidAmount >= $structure->amount ? 'Fully Paid' : ($paidAmount > 0 ? 'Partially Paid' : 'Not Paid')
            ]);
        }

        $monthlyAmount = $structure->amount;
        $academicStartMonth = 4; // April
        $currentMonth = (int) date('n');

        $monthsTillNow = max(0, $currentMonth - $academicStartMonth + 1);
        $totalAmount = $monthlyAmount * $monthsTillNow;

        $paidMonths = $payments->pluck('month')->map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT))->toArray();
        $paidSet = collect($paidMonths)->unique()->toArray();

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
