<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
@php
use App\Models\Category;
$saldo = 0;
$total_debit = 0;
$total_kredit = 0;
@endphp

<body>
    <div class="table-responsive">
        <div class="text-center">
            <h2>LAPORAN KEUANGAN BULANAN</h2>
            <h3>SIM-CAKEP</h3>
            <br>
        </div>
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
                        <td>{{ $row->Category->type == Category::TYPE['INCOME'] ? number_format($row->amount, 0) : '-' }}
                        </td>
                        <td>{{ $row->Category->type == Category::TYPE['EXPENSE'] ? number_format($row->amount, 0) : '-' }}
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
                        <td>{{ number_format($saldo, 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class=" ">
                    <td colspan="3" class="text-right">Jumlah</td>
                    <td>{{ $total_debit }}</td>
                    <td>{{ $total_kredit }}</td>
                    <td>{{ $saldo }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
