<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {

        $month = isset($request->bulan) ? $request->bulan : date('Y-m');

        $income = Income::orderBy('date', 'asc')
            ->with('Category')
            ->whereHas('Category', function ($query) {
                $query->where('type', Category::TYPE['INCOME']);
            })
            ->where('id_user', Auth::user()->id)
            ->where('date', 'LIKE', "%$month%")
            ->get();

        $expense = Expense::orderBy('date', 'asc')
            ->with('Category')
            ->whereHas('Category', function ($query) {
                $query->where('type', Category::TYPE['EXPENSE']);
            })
            ->where('id_user', Auth::user()->id)
            ->where('date', 'LIKE', "%$month%")
            ->get();

        $report = [];
        foreach ($income as $row) {
            $report[] = $row;
        }
        foreach ($expense as $row) {
            $report[] = $row;
        }

        $report = array_values(Arr::sort($report, function ($value) {
            return $value->date;
        }));

        $data = [
            'title' => 'Report',
            'report' => $report
        ];

        if (isset($request->export) && $request->export) {
            // dd($data);
            $pdf = PDF::loadview('report.export', $data)
                ->setPaper('f4', 'potrait');
            $pdf->setOptions(
                [
                    'dpi' => 150,
                    'defaultFont' => 'arial',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true
                ]
            );
            return $pdf->stream('REPORT_' . Carbon::now() . '.pdf');
        }

        return view('report.index', $data);
    }
}
