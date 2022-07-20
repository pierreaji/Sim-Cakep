@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('expense.index') }}" class="d-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-bars fa-sm text-white-50"></i> List {{ $title }}</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $title }} Form</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('expense.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label class="text-primary">Tanggal</label>
                    <input type="date" name="date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="text-primary">Jumlah</label>
                    <input type="hidden" name="amount" class="form-control" required placeholder="10000">
                    <input type="text" id="amount" class="form-control" required placeholder="10000">
                </div>
                <div class="form-group">
                    <label class="text-primary">Kategori</label>
                    <select name="id_category" id="category" class="form-control" required>
                        <option value="" selected disabled>Pilih Kategori</option>
                        @foreach ($category as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="text-primary">Deskripsi</label>
                    <input type="text" name="desc" class="form-control" placeholder="Desc">
                    <small class="text-danger">*Abaikan jika tidak ada</small>
                </div>
                <button class="btn btn-primary">
                    <i class="fas fa-save fa-sm text-white-50"></i> Simpan
                </button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        const formatRupiah = (angka, prefix) => {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        $('#amount').on('keyup', function() {
            let amount = $(this).val()
            $('input[name=amount]').val(amount.replace('.', ''))
            $(this).val(formatRupiah(amount))
        })
    </script>
@endsection

