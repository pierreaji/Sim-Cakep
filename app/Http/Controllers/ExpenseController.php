<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Database\Console\DbCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $expense = Expense::orderBy('id', 'desc')
            ->with('Category')
            ->whereHas('Category', function ($query) {
                $query->where('type', Category::TYPE['EXPENSE']);
            })
            ->where([
                ['id_user', Auth::user()->id],
                ['date', 'LIKE', '%' . now()->format('y-m'). '%']
            ]);

        if (isset($request->category)) {
            $expense->where('id_category', $request->category);
        }

        $data = [
            'title' => 'Pengeluaran',
            'expense' => $expense->get(),
            'category' =>  Category::orderBy('id', 'desc')
                ->where('id_user', Auth::user()->id)
                ->where('type', Category::TYPE['EXPENSE'])
                ->get()
        ];

        return view('expense.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('id_user', Auth::user()->id)
            ->where('type', Category::TYPE['EXPENSE'])
            ->get();

        $data = [
            'title' => 'Pengeluaran',
            'category' => $category
        ];

        return view('expense.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $income = Income::where('id_user', Auth::user()->id)->where('date', 'LIKE', '%' . now()->format('y-m'). '%')->sum('amount');
        $expense = Expense::where('id_user', Auth::user()->id)->where('date', 'LIKE', '%' . now()->format('y-m'). '%')->sum('amount');
        $saldo = $income - $expense;

        if ($saldo < $request->amount) {
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Jumlah pengeluaran tidak bisa lebih besar dari pada jumlah saldo saat ini!');
            return redirect()->to(route('expense.index'));
        }
        else {
            try {
                DB::beginTransaction();

                $expense = new Expense();
                $expense->id_user = Auth::user()->id;
                $expense->date = $request->date;
                $expense->amount = $request->amount;
                $expense->desc = $request->desc;
                $expense->id_category = $request->id_category;
                $expense->save();

                DB::commit();

                $request->session()->flash('alert', 'success');
                $request->session()->flash('message', 'Pengeluaran berhasil disimpan');
                return redirect()->to(route('expense.index'));
            } catch (\Exception $error) {
                DB::rollBack();
                $request->session()->flash('alert', 'danger');
                $request->session()->flash('message', 'Pengeluaran gagal disimpan!');
                return redirect()->to(route('expense.index'));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = Expense::find($id);
        $category = Category::where('id_user', Auth::user()->id)
            ->where('type', Category::TYPE['EXPENSE'])
            ->get();

        $data = [
            'title' => 'Pengeluaran',
            'expense' => $expense,
            'category' => $category
        ];

        return view('expense.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $expense = Expense::find($id);
            $expense->date = $request->date;
            $expense->amount = $request->amount;
            $expense->desc = $request->desc;
            $expense->id_category = $request->id_category;
            $expense->save();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'Pengeluaran berhasil diupdate');
            return redirect()->to(route('expense.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Pengeluaran gagal diupdate!');
            return redirect()->to(route('expense.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $expense = Expense::find($id);
            $expense->delete();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'Pengeluaran berhasil dihapus');
            return redirect()->to(route('expense.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Pengeluaran gagal dihapus!');
            return redirect()->to(route('expense.index'));
        }
    }
}
