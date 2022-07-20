<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Income;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $year = isset($request->year) ? explode('-', $request->year)[0] : Carbon::now()->year;
        $month = isset($request->year) ? explode('-', $request->year)[1] : date('m');

        $data = [
            'title' => 'Dashboard',
            'income' => Income::where('id_user', Auth::user()->id)->where('date', 'LIKE', '%' . now()->format('y-m'). '%')->sum('amount'),
            'expense' => Expense::where('id_user', Auth::user()->id)->where('date', 'LIKE', '%' . now()->format('y-m'). '%')->sum('amount'),
            'category' => Category::count(),
            'user' => User::count(),
            'allincome' => Income::count(),
            'allexpense' => Expense::count(),
            'perempuan' => User::where('jenis_kelamin', 'LIKE', '%P%')->count(),
            'laki' => User::where('jenis_kelamin', 'LIKE', '%L%')->count(),
            'report' => [
                'income_amount' => Income::selectRaw('SUM(amount) as amount')->groupByRaw('MONTH(date)')->where('date', 'LIKE', "%$year%")->where('id_user', Auth::user()->id)->get()->pluck('amount'),
                'income_month' => Income::selectRaw('MONTH(date) as month')->groupByRaw('MONTH(date)')->where('date', 'LIKE', "%$year%")->where('id_user', Auth::user()->id)->get()->pluck('month'),
                'expense_amount' => Expense::selectRaw('SUM(amount) as amount')->groupByRaw('MONTH(date)')->where('date', 'LIKE', "%$year%")->where('id_user', Auth::user()->id)->get()->pluck('amount'),
                'expense_month' => Expense::selectRaw('MONTH(date) as month')->groupByRaw('MONTH(date)')->where('date', 'LIKE', "%$year%")->where('id_user', Auth::user()->id)->get()->pluck('month'),
            ]
        ];
        return view('home', $data);
    }
}
