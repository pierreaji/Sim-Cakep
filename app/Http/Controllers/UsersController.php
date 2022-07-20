<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Users',
            'users' => User::orderBy('id', 'desc')
                ->where('email', '!=', 'alrofiqy@gmail.com')
                ->get()
        ];

        return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Users'
        ];

        return view('users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'unique:users',
        ]);

        try {

            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->save();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'User berhasil ditambahkan');
            return redirect()->to(route('users.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'User gagal ditambahkan!');
            return redirect()->to(route('users.index'));
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
        $user = User::find($id);
        // dd($expenseCount);

        $data = [
            'title' => 'Users',
            'user' => $user,
        ];

        return view('users.edit', $data);
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
        $request->validate([
            'email' => 'unique:users,email,' . $id,
        ]);

        try {

            DB::beginTransaction();

            $user = User::find($id);
            $user->name = $request->name;
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->email = $request->email;
            if (isset($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->role = $request->role;
            $user->save();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'User berhasil diupdate');
            return redirect()->to(route('users.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'User gagal diupdate!');
            return redirect()->to(route('users.index'));
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

            $user = User::find($id);
            $user->delete();

            DB::commit();

            $request->session()->flash('alert', 'success');
            $request->session()->flash('message', 'User berhasil dihapus');
            return redirect()->to(route('users.index'));
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'User gagal dihapus!');
            return redirect()->to(route('users.index'));
        }
    }
}
