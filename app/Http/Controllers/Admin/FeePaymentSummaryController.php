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
        $feeTypes = FeeType::all();
        $classes = ClassModel::all();
        $sections = Section::all();
        $initialSummary = [];

        $academicStartMonth = 4; // April
        $currentMonth = (int) date('n');

        // Filters
        $classId = request('class_id');
        $sectionId = request('section_id');
        $name = request('name');
        $rollNo = request('roll_no');

        // Students with filters
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

            $requiredMonthlyFeeTypes = $structures->filter(fn($s) => $s->frequency === 'monthly')
                ->pluck('fee_type_id')
                ->unique()
                ->toArray();

            foreach ($structures as $structure) {
                $total += $structure->frequency === 'monthly'
                    ? $structure->amount * 12
                    : $structure->amount;
            }

            $paidMonthMap = [];
          foreach ($payments as $payment) {
    $feeTypeId = $payment->fee_type_id;
    
    $months = is_array($payment->months)
        ? $payment->months
        : (json_decode($payment->months, true) ?? []);

    foreach ($months as $month) {
        $code = str_pad($month, 2, '0', STR_PAD_LEFT);
        $paidMonthMap[$code][$feeTypeId] = true;
    }
}

            $monthFlags = [];
            foreach (range(1, 12) as $m) {
                $code = str_pad($m, 2, '0', STR_PAD_LEFT);
                if ($m < $academicStartMonth || $m > $currentMonth) {
                    $monthFlags[$code] = 'none';
                } else {
                    $paidForMonth = isset($paidMonthMap[$code]) ? array_keys($paidMonthMap[$code]) : [];
                    $allPaid = empty(array_diff($requiredMonthlyFeeTypes, $paidForMonth));
                    $monthFlags[$code] = $allPaid ? 'paid' : 'due';
                }
            }

            $status = 'Not Paid';
            if ($paid >= $total) {
                $status = 'Fully Paid';
            } elseif ($paid > 0) {
                $status = 'Partially Paid';
            }

            $initialSummary[$student->id] = [
                'total' => number_format($total, 2),
                'paid' => number_format($paid, 2),
                'due' => number_format(max(0, $total - $paid), 2),
                'status' => $status,
                'months' => $monthFlags
            ];
        }

        return view('page.admin.fee.fee-payment-summary', compact(
            'students', 'feeTypes', 'initialSummary', 'classes', 'sections'
        ));
    }

    public function getFeeMonths(Request $request)
    {
        $paidMonths = FeePayment::where('student_id', $request->student_id)
            ->where('fee_type_id', $request->fee_type_id)
            ->get()
            ->flatMap(fn($p) => $p->months ?? [])
            ->map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT))
            ->unique()
            ->values()
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
            ->firstOrFail();

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
        $academicStartMonth = 4;
        $currentMonth = (int) date('n');
        $monthsTillNow = max(0, $currentMonth - $academicStartMonth + 1);
        $totalAmount = $monthlyAmount * $monthsTillNow;

        $paidMonths = $payments->flatMap(fn($p) => $p->months ?? [])
            ->map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT))
            ->unique()
            ->values()
            ->toArray();

        $applicableMonths = collect(range($academicStartMonth, $currentMonth))
            ->map(fn($m) => str_pad($m, 2, '0', STR_PAD_LEFT))
            ->toArray();

        $dueMonths = array_values(array_diff($applicableMonths, $paidMonths));

        $status = 'Not Paid';
        if ($paidAmount >= $totalAmount) {
            $status = 'Fully Paid';
        } elseif ($paidAmount > 0) {
            $status = 'Partially Paid';
        }

        return response()->json([
            'paidMonths' => $paidMonths,
            'dueMonths' => $dueMonths,
            'paidAmount' => number_format($paidAmount, 2),
            'totalAmount' => number_format($totalAmount, 2),
            'dueAmount' => number_format($totalAmount - $paidAmount, 2),
            'status' => $status
        ]);
    }
}
