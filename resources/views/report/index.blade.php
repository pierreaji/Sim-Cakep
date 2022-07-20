@extends('layouts.app')
@php
use App\Models\Category;
$saldo = 0;
$total_debit = 0;
$total_kredit = 0;
@endphp
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
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{ $title }} List</h6>
            <button class="btn btn-success btn-sm btn-export">Export</button>
        </div>
        <div class="card-body">
            <form action="" id="form-bulan" method="get">
                <div class="form-group">
                    <label>Filter Bulan</label>
                    <input type="hidden" name="export" class="is-export" disabled="true" value="true" />
                    <input type="month" name="bulan" class="form-control select-bulan"
                        value="{{ Request::get('bulan') ? Request::get('bulan') : date('Y-m') }}">
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="report" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-white bg-primary">No</th>
                            <th class="text-white bg-primary">Tanggal</th>
                            <th class="text-white bg-primary">Keterangan</th>
                            <th class="text-white bg-primary">Debet</th>
                            <th class="text-white bg-primary">Kredit</th>
                            <th class="text-white bg-primary">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($report as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ date('d/m/Y', strtotime($row->date)) }}</td>
                                <td>{{ $row->Category->name }}</td>
                                <td>Rp. {{ $row->Category->type == Category::TYPE['INCOME'] ? number_format($row->amount, 0) : '-' }}
                                </td>
                                <td>Rp. {{ $row->Category->type == Category::TYPE['EXPENSE'] ? number_format($row->amount, 0) : '-' }}
                                </td>
                                @php
                                    if ($row->Category->type == Category::TYPE['INCOME']) {
                                        $saldo += $row->amount;
                                        $total_debit += $row->amount;
                                    } else {
                                        $saldo -= $row->amount;
                                        $total_kredit += $row->amount;
                                    }
                                @endphp
                                <td>Rp. {{ number_format($saldo, 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="">
                            <td colspan="3" class="text-right">Jumlah</td>
                            <td>Rp. {{ number_format($total_debit) }}</td>
                            <td>Rp. {{ number_format($total_kredit) }}</td>
                            <td>Rp. {{ number_format($saldo) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $('.select-bulan').on('change', function() {
            $('.is-export').attr('disabled', true)
            $('#form-bulan').submit()
        })
        $('.btn-export').on('click', function() {
            $('.is-export').attr('disabled', false)
            $('#form-bulan').submit()
        })

        $(document).ready(function() {
            $('#report').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endsection
