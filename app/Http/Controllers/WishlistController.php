<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Wishlist',
            'wishlist' => Wishlist::orderBy('id', 'desc')
                ->where('id_user', Auth::user()->id)
                ->get()
        ];

        return view('wishlist.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Wishlist',
        ];

        return view('wishlist.create', $data);
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

            $wishlist = new Wishlist();
            $wishlist->id_user = Auth::user()->id;
            $wishlist->name = $request->name;
            $wishlist->target = $request->target;
            $wishlist->save();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'Wishlist berhasil disimpan');
            return redirect()->to(route('wishlist.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Wishlist gagal disimpan!');
            return redirect()->to(route('wishlist.index'));
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
        $Wishlist = Wishlist::find($id);
        $data = [
            'title' => 'Wishlist',
            'wishlist' => $Wishlist
        ];
        return view('wishlist.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Wishlist = Wishlist::find($id);
        $data = [
            'title' => 'Wishlist',
            'wishlist' => $Wishlist
        ];

        return view('wishlist.edit', $data);
    }

     /**
     * Show the form for Detail the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $wishlist = Wishlist::where('id', $id)->sum('amount');
        if ($wishlist <= $request->amount) {
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Dana melebihi target yang ditentukan!');
            return redirect()->to(route('wishlist.index'));
        }
        else {
            try {
                DB::beginTransaction();
                $wishlist = Wishlist::find($id);
                $p = $wishlist->amount + $request->amount;
                $wishlist->amount = $p;
                $wishlist->save();

                DB::commit();

                $request->session()->flash('alert', 'success');
                $request->session()->flash('message', 'Wishlist berhasil diupdate');
                return redirect()->to(route('wishlist.index'));
            } catch (\Exception $error) {
                DB::rollBack();
                $request->session()->flash('alert', 'danger');
                $request->session()->flash('message', 'Wishlist gagal diupdate!');
                return redirect()->to(route('wishlist.index'));
            }
        }
    }

    public function add(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $wishlist = Wishlist::find($id);
            $wishlist->amount = $request->amount;
            $wishlist->save();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'Wishlist berhasil diupdate');
            return redirect()->to(route('wishlist.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Wishlist gagal diupdate!');
            return redirect()->to(route('wishlist.index'));
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

            $Wishlist = Wishlist::find($id);
            $Wishlist->delete();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'Wishlist berhasil dihapus');
            return redirect()->to(route('wishlist.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Wishlist gagal dihapus!');
            return redirect()->to(route('wishlist.index'));
        }
    }
}
