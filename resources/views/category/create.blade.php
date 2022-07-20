@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('category.index') }}" class="d-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-bars fa-sm text-white-50"></i> List {{ $title }}</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $title }} Form</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('category.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label class="text-primary">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="text-primary">Type</label>
                    <select name="type" class="form-control" required>
                        <option value="" selected disabled>Pilih Tipe Kategori</option>
                        <option value="Pemasukan">Pemasukan</option>
                        <option value="Pengeluaran">Pengeluaran</option>
                    </select>
                </div>
                <button class="btn btn-primary">
                    <i class="fas fa-save fa-sm text-white-50"></i> Simpan
                </button>
            </form>
        </div>
    </div>
@endsection
