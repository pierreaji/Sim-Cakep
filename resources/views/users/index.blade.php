@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    @if (Session::has('alert'))
        <div class="alert alert-{{ Session::get('alert') }}" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $title }} List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-white bg-primary">No</th>
                            <th class="text-white bg-primary">Name</th>
                            <th class="text-white bg-primary">Email</th>
                            <th class="text-white bg-primary">Role</th>
                            <th class="text-white bg-primary">Created At</th>
                            <th class="text-white bg-primary">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td class="">{{ $row->role }}</td>
                                <td>{{ date('d/m/Y H:i:s', strtotime($row->created_at)) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('users.edit', ['user' => $row->id]) }}"
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
        $('.button-delete').on('click', function() {
            let form = $('.form-delete')
            let id = $(this).attr('data-id')
            form.attr('action', "{{ url('users') }}/" + id)
            Swal.fire({
                title: 'Apa Anda Yakin?',
                text: "User akan dihapus!",
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
                        html: 'Sedang menghapus User...',
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
