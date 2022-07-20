@extends('layouts.app')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('wishlist.index') }}" class="d-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-bars fa-sm text-white-50"></i> List {{ $title }}</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $title }} Detail</h6>
        </div>
        <div class="card-body">
            <div class="form-group">
                <div class="mb-1 small">Progress Wishlist</div>
                <div class="progress mb-4">
                @php
                    $p = $wishlist->amount / $wishlist->target;
                    $persen = $p * 100;
                @endphp
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $persen }}%"
                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="{{ $wishlist->target }}">{{ round($persen,0,PHP_ROUND_HALF_ODD) }}%</div>
                </div>
                </div>
                <div class="form-group">
                    <label class="text-primary">Nama Wishlist : </label>
                    {{ $wishlist->name}}
                </div>
                <div class="form-group">
                    <label class="text-primary">Target : </label>
                  Rp.  {{ number_format($wishlist->target) }}
                </div>
                <div class="form-group">
                    <label class="text-primary">Dana Terkumpul : </label>
                  Rp.  {{ number_format($wishlist->amount) }}
                </div>
                <div class="form-group">
                @php
                    $cek = $wishlist->target - $wishlist->amount;
                @endphp
                    <label class="text-primary">Dana Kurang : </label>
                  Rp.  {{ number_format($cek) }}
                </div>
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

        $('#target').on('keyup', function() {
            let target = $(this).val()
            $('input[name=target]').val(target.replace('.', ''))
            $(this).val(formatRupiah(target))
        })
    </script>
@endsection
