@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('users.index') }}" class="d-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-bars fa-sm text-white-50"></i> List {{ $title }}</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $title }} Form</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label class="text-primary">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <select name="jenis_kelamin" class="form-control">
                    <option value="" selected disabled>Pilih Gender</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki - Laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
                <div class="form-group">
                    <label class="text-primary">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="text-primary">Role</label>
                    <select name="role" class="form-control">
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="text-primary">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-primary">
                    <i class="fas fa-save fa-sm text-white-50"></i> Simpan
                </button>
            </form>
        </div>
    </div>
@endsection
