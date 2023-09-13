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
            margin-top: 5px;
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
            width:98%;
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
        
        tbody td{
            text-align: center;
            padding: 0 5px;
        }

        .page-break {
            page-break-after: always;
        }
        @page { margin: 20px auto; }

        /* @page { margin: 100px 20px 20px 20px; } */
        /* header { position: fixed; top: -50px; left: 0px; right: 20px; height: 50px; } */
        p { page-break-after: always;line-height:15pt }
        p:last-child { page-break-after: never; }

        @media print{@page {size: landscape}}
    </style>
</head>
<body>
    
    <table class="table">
        <thead>
            <tr>
                <th style="font-size:8pt">No.</th>
                <th style="font-size:8pt">Divisi</th>
                <th style="font-size:8pt">Nik</th>
                <th style="font-size:8pt">Nama</th>
                <th style="font-size:8pt">Jabatan</th>
                <th style="font-size:8pt">Waktu Kerja</th>
                <th style="font-size:8pt">Tanggal</th>
                <th style="font-size:8pt">Hari</th>
                <th style="font-size:8pt">Masuk</th>
                <th style="font-size:8pt">Pulang</th>
                <th style="font-size:8pt">Potongan Umak</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($data as $key => $row)
                @foreach ($row->overtime as $overtime => $value)
                    @foreach ($value->detail as $detail => $people)
                    <tr>
                        <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $no++ }}</td>
                        <td style="text-align: left;border: 1px solid #aaaaaa; font-size:8pt">{{$row->kode}} - {{$row->nama}}</td>
                        <td style="border: 1px solid #aaaaaa; font-size:8pt">{{$people->nik}}</td>
                        <td style="text-align: left;border: 1px solid #aaaaaa; font-size:8pt">{{$people->nama}}</td>
                        <td style="text-align: right;border: 1px solid #aaaaaa; font-size:8pt">{{$people->jabatan}}</td>
                        <td style="text-align: right;border: 1px solid #aaaaaa; font-size:8pt">{{$value->waktu}}</td>
                        <td style="text-align: right;border: 1px solid #aaaaaa; font-size:8pt">{{ \Carbon\Carbon::parse($value->tanggalspl)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F, Y') }}</td>
                        <td style="text-align: right;border: 1px solid #aaaaaa; font-size:8pt">{{ \Carbon\Carbon::parse($value->tanggalspl)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('l') }}</td>
                        <td style="text-align: right;border: 1px solid #aaaaaa; font-size:8pt">{{$people->masuk}}</td>
                        <td style="text-align: right;border: 1px solid #aaaaaa; font-size:8pt">{{$people->pulang}}</td>
                        <td style="text-align: right;border: 1px solid #aaaaaa; font-size:8pt">{{$people->is_umak_cut == "0" ? "Tidak" : ($people->is_umak_cut == "1" ? "Ya" : "")}}</td>
                    </tr>
                    @endforeach
                @endforeach
            @php
                
            @endphp
            @endforeach

            
        </tbody>
    </table>
    
</body>
</html>