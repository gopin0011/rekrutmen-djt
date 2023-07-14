<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak SPL</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body{
            font-family:'Arial';
            color:#333;
            text-align:left;
            font-size:12px;
            margin: 0px;
        }
        .container{
            margin:0 auto;
            margin-top:35px;
            padding:40px;
            width:750px;
            height:auto;
            background-color:#fff;
        }
        caption{
            font-size:20px;
            margin-bottom:15px;
        }
        table{
            
            width:100%;
        }
        .table{
            border:0px solid #333;
            border-collapse:collapse;
            margin:0 auto;
            width:90%;
        }
        th{
            padding:3px;
            border:1px solid #aaaaaa;  
            font-size: 10pt;
            background-color: #cccccc;
        }
        
        tr{
            /* padding:3px;  
            font-size: 10pt; */
        }

        td {
            /* padding:3px;
            font-size: 10pt; */
        }

        h4, p{
            margin:0px;
            
        }
        /* table{
            border: 0px;
            margin-left: 1cm;
            margin-right: 2cm;
        } */
        
        tbody{
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }
        @page { margin: 40px auto; }

        /* @page { margin: 100px 20px 20px 20px; } */
        /* header { position: fixed; top: -50px; left: 0px; right: 20px; height: 50px; } */
        p { page-break-after: always;line-height:15pt }
        p:last-child { page-break-after: never; }

        @media print{@page {size: landscape}}
    </style>
</head>
<body>
    <header>
        @foreach ($overtime as $overtime)
        <table class="table">
            <tr>
                <td style="text-align: left"><strong>SURAT PERINTAH LEMBUR</strong></td>
                <td style="text-align: right"><img src="{{asset('logo.png')}}" width="200"></td>
            </tr>
            
        </table>
        @endforeach
    </header>
    <br>
    <br>
    <table class="table">
        <thead>
            <tr>
                <td colspan="13">
                    <table>
                        <tr>
                            <td style="text-align: left;font-size:8pt">Tanggal SPL    : <strong>{{ \Carbon\Carbon::parse($overtime->created_at)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y') }}</strong></td>
                            <td style="text-align: right;font-size:8pt"></td>
                        </tr>
                        <tr>
                            <td style="text-align: left;font-size:8pt">Nomor SPL    : <strong>{{ $overtime->nomor }}</strong></td>
                            <td style="text-align: right;font-size:8pt">Departemen/Divisi   : <strong>{{ $overtime->bisnis }}/{{ $overtime->divisi }}</strong></td>
                        </tr>
                        <tr>
                            <td style="text-align: left;font-size:8pt">Tanggal Lembur   : <strong>{{ \Carbon\Carbon::parse($overtime->tanggalspl)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('l, j F Y') }}</strong></td>
                            <td style="text-align: right;font-size:8pt">Waktu Lembur    : <strong>{{ $overtime->waktu }}</strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th rowspan="2" style="font-size:8pt">NIK</th>
                <th rowspan="2" style="font-size:8pt">Nama</th>
                <th rowspan="2" style="font-size:8pt">Jabatan</th>
                <th rowspan="2" style="font-size:8pt">Pekerjaan</th>
                <th rowspan="2" style="font-size:8pt">SPK</th>
                <th rowspan="2" style="font-size:8pt">No. SPK</th>
                <th colspan="2" style="font-size:8pt">{{$tglSplSebelumnya['2hari']}}</th>
                <th colspan="2" style="font-size:8pt">{{$tglSplSebelumnya['1hari']}}</th>
                <th colspan="2" style="font-size:8pt">Jam Lembur</th>
                <th style="font-size:8pt">Total Jam</th>
                <!-- <th style="font-size:8pt">Berakhir</th> -->
                <!-- <th style="font-size:8pt">Lembur</th> -->
            </tr>
            <tr>
                <!-- <th style="font-size:8pt">NIK</th> -->
                <!-- <th style="font-size:8pt">Nama</th> -->
                <!-- <th style="font-size:8pt">Jabatan</th> -->
                <!-- <th style="font-size:8pt">Pekerjaan</th> -->
                <!-- <th style="font-size:8pt">SPK</th> -->
                <!-- <th style="font-size:8pt">No. SPK</th> -->
                <th style="font-size:8pt">Hasil</th>
                <th style="font-size:8pt">Persen</th>
                <th style="font-size:8pt">Hasil</th>
                <th style="font-size:8pt">Persen</th>
                <th style="font-size:8pt">Mulai</th>
                <th style="font-size:8pt">Berakhir</th>
                <th style="font-size:8pt">Lembur</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $row)
            <tr>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $row->nik }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $row->nama }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $row->jabatan }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $row->pekerjaan }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $row->spk }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $row->nospk }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $row->hasil2 }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $row->persen2 }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $row->hasil }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $row->persen }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $row->mulai }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $row->akhir }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ intdiv(($row->total),60) .'.'. ($row->total)%60 }}</td>
            </tr>
            @endforeach
            <tr>
                <td style="border: 1px solid #aaaaaa; font-size:8pt" colspan="12">TOTAL WAKTU LEMBUR</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ intdiv(($detail->sum('total')),60) .'.'. ($detail->sum('total'))%60 }}</td>
            </tr>
        </tbody>
    </table>

    <table style="margin-top:30px" class="table">
        <tbody>
            <tr>
                <th style="font-size:8pt">Diajukan oleh,</th>
                <th style="font-size:8pt">Disetujui oleh,</th>
                <th style="font-size:8pt">Diketahui oleh,</th>
                <th></th>
            </tr>
            <tr>
                <td style="border: 1px solid #aaaaaa; font-size:8pt; height: 60px;vertical-align: bottom;">{{ $overtime->pemohon }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt;vertical-align: bottom;">{{ $overtime->nmmanajer }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt;vertical-align: bottom;">{{ $overtime->nmhr }}</td>
                <td style="border: 1px solid #aaaaaa; font-size:8pt;vertical-align: bottom;">
                    <table style="border:0px solid #333;border-collapse:collapse;">
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                        @php $total = 0; @endphp
                        @foreach ($makan as $key => $data)
                        @php $total+= $data; @endphp
                        <tr>
                            <td style="border-bottom: 1px solid #aaaaaa; font-size:8pt">{{$key}}</td>
                            <td style="border-bottom: 1px solid #aaaaaa; font-size:8pt">{{$data}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td style="font-size:8pt; background-color: #cccccc;">Total</td>
                            <td style="font-size:8pt; background-color: #cccccc;">{{$total}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>