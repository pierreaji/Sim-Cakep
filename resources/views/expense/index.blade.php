@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('expense.create') }}" class="d-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah {{ $title }}</a>
    </div>
    @if (Session::has('alert'))
        <div class="alert alert-{{ Session::get('alert') }}" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar {{ $title }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-white bg-primary">No</th>
                            <th class="text-white bg-primary">Tanggal</th>
                            <th class="text-white bg-primary">Jumlah</th>
                            <th class="text-white bg-primary">Kategori</th>
                            <th class="text-white bg-primary">Deskripsi</th>
                            <th class="text-white bg-primary">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expense as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->date }}</td>
                                <td>Rp. {{ number_format($row->amount, 0) }}</td>
                                <td>{{ $row->Category->name }}</td>
                                <td>{{ $row->desc }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('expense.edit', ['expense' => $row->id]) }}"
                                            class="btn btn-success btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm button-delete" data-id="{{ $row->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <form action="" class="form-delete d-none" method="post">
        @method('DELETE')
        @csrf
    </form>
@endsection
@section('script')
    <script type="text/javascript">
        $('.select-category').on('change', function() {
            $('#form-category').submit()
        })

        $('.button-delete').on('click', function() {
            let form = $('.form-delete')
            let id = $(this).attr('data-id')
            form.attr('action', "{{ url('expense') }}/" + id)
            Swal.fire({
                title: 'Apa Anda Yakin?',
                text: "Pengeluaran akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tunggu Sebentar...',
                        html: 'Sedang menghapus pengeluaran...',
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })
                    form.submit()
                }
            })
        })
    </script>
@endsection
