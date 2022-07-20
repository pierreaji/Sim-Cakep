<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Kategori',
            'category' => Category::orderBy('id', 'desc')
                ->where('id_user', Auth::user()->id)
                ->get()
        ];

        return view('category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Kategori'
        ];

        return view('category.create', $data);
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

            $category = new Category();
            $category->id_user = Auth::user()->id;
            $category->name = $request->name;
            $category->type = $request->type;
            $category->save();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'Kategori berhasil disimpan');
            return redirect()->to(route('category.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Kategori gagal disimpan!');
            return redirect()->to(route('category.index'));
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
        $category = Category::find($id);
        $incomeCount = Income::where('id_category', $id)->count();
        $expenseCount = Expense::where('id_category', $id)->count();
        // dd($expenseCount);

        $data = [
            'title' => 'Kategori',
            'category' => $category,
            'nullRelation' => ($incomeCount + $expenseCount)
        ];

        return view('category.edit', $data);
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

            $category = Category::find($id);
            $category->name = $request->name;
            $category->type = $request->type;
            $category->save();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'Kategori berhasil diupdate');
            return redirect()->to(route('category.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Kategori gagal diupdate');
            return redirect()->to(route('category.index'));
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

            $category = Category::find($id);
            $category->delete();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'Kategori berhasil dihapus');
            return redirect()->to(route('category.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Kategori gagal dihapus!');
            return redirect()->to(route('category.index'));
        }
    }
}
