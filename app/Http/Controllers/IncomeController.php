<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $income = Income::orderBy('id', 'desc')
            ->with('Category')
            ->whereHas('Category', function ($query) {
                $query->where('type', Category::TYPE['INCOME']);
            })
            ->where([
                ['id_user', Auth::user()->id],
                ['date', 'LIKE', '%' . now()->format('y-m'). '%']
            ]);

        if (isset($request->category)) {
            $income->where('id_category', $request->category);
        }

        $data = [
            'title' => 'Pemasukan',
            'income' => $income->get(),
            'category' =>  Category::orderBy('id', 'desc')
                ->where('id_user', Auth::user()->id)
                ->where('type', Category::TYPE['INCOME'])
                ->get()
        ];

        return view('income.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('id_user', Auth::user()->id)
            ->where('type', Category::TYPE['INCOME'])
            ->get();

        $data = [
            'title' => 'Pemasukan',
            'category' => $category
        ];

        return view('income.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $income = new Income();
            $income->id_user = Auth::user()->id;
            $income->date = $request->date;
            $income->amount = $request->amount;
            $income->desc = $request->desc;
            $income->id_category = $request->id_category;
            $income->save();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'Pemasukan berhasil disimpan');
            return redirect()->to(route('income.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Pemasukan gagal disimpan!');
            return redirect()->to(route('income.index'));
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
        $income = Income::find($id);
        $category = Category::where('id_user', Auth::user()->id)
            ->where('type', Category::TYPE['INCOME'])
            ->get();

        $data = [
            'title' => 'Pemasukan',
            'income' => $income,
            'category' => $category
        ];

        return view('income.edit', $data);
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

            $income = Income::find($id);
            $income->date = $request->date;
            $income->amount = $request->amount;
            $income->desc = $request->desc;
            $income->id_category = $request->id_category;
            $income->save();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'Pemasukan berhasil diupdate');
            return redirect()->to(route('income.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Pemasukan gagal diupdate!');
            return redirect()->to(route('income.index'));
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

            $Income = Income::find($id);
            $Income->delete();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'Pemasukan berhasil dihapus');
            return redirect()->to(route('income.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Pemasukan gagal dihapus!');
            return redirect()->to(route('income.index'));
        }
    }
}
