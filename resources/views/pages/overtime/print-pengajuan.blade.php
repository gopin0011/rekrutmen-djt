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
        
        tbody td{
            text-align: center;
            padding: 0 5px;
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
    <table class="">
        <tr>
            <td style="font-size:12pt"><b>FORM PENGAJUAN DANA</b></td>
        </tr>
        <tr>
            <td>
                <table class="table" style="margin-top: 10px;">
                    <tr>
                        <td width="120px" style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">Tanggal</td>
                        <td style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">: {{ \Carbon\Carbon::parse($tanggalspl)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F Y') }}</td>
                        <td width="90px" style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">: Posting</td>
                        <td width="5px" style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt;">&nbsp;</td>
                        <td width="200px" style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">[&nbsp;]&nbsp;Project</td>

                    </tr>
                    <tr>
                        <td style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">PT</td>
                        <td style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">: DJT</td>
                        <td style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">:</td>
                        <td style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">&nbsp;</td>
                        <td style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">[&nbsp;]&nbsp;Operasional</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">Dari</td>
                        <td style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">: HRD</td>
                        <td style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">:</td>
                        <td style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">&nbsp;</td>
                        <td style="border: 1px solid #aaaaaa;text-align: left;font-size:8pt">[&nbsp;]&nbsp;Lain-lain</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>Dengan ini mengajukan permohonan dana untuk keperluan sebagai berikut:</td>
        </tr>
        <tr>
            <td>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="font-size:8pt">No.</th>
                            <th colspan="2" style="font-size:8pt">URAIAN</th>
                            <th style="font-size:8pt">NAMA PROYEK/KEG.</th>
                            <th style="font-size:8pt">JUMLAH</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                            $totalRupiah =  0;
                        @endphp
                        @foreach ($detail as $k => $r)
                            <tr>
                                <td style="border: 1px solid #aaaaaa; font-size:8pt">&nbsp;</td>
                                <td style="text-align: left;border: 1px solid #aaaaaa; font-size:8pt" colspan="4"><b>{{strtoupper($k)}}</b></td>
                            </tr>
                            @foreach ($r['dept'] as $key => $row)
                            <tr>
                                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $loop->iteration }}</td>
                                <td style="text-align: left;border: 1px solid #aaaaaa; font-size:8pt">{{$key}}</td>
                                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{count($row['people'])}}</td>
                                <td style="text-align: left;border: 1px solid #aaaaaa; font-size:8pt">{{$row['kegiatan']}}</td>
                                <td style="text-align: right;border: 1px solid #aaaaaa; font-size:8pt">Rp. {{ number_format(str_replace('.', '', count($row['people']) * 15000)) }}</td>
                            </tr>
                            @php
                                $last = $loop->iteration;
                                $total+=count($row['people']);
                                $totalRupiah += count($row['people']) * 15000;
                            @endphp
                            @endforeach

                            @foreach ($r['pengajuanDana']['detail'] as $key => $row)
                            @php
                                $last += 1;
                                $totalRupiah += $row[1];
                            @endphp 
                            <tr>
                                <td style="border: 1px solid #aaaaaa; font-size:8pt">{{ $last }}</td>
                                <td colspan="2" style="text-align: left;border: 1px solid #aaaaaa; font-size:8pt">{{$row[0]}}</td>
                                <td style="border: 1px solid #aaaaaa; font-size:8pt"></td>
                                <td style="text-align: right;border: 1px solid #aaaaaa; font-size:8pt">Rp. {{ number_format(str_replace('.', '', $row[1])) }}</td>
                            </tr>
                            @endforeach
                        @endforeach
                        <tr>
                            <td style="border: 1px solid #aaaaaa; font-size:8pt"></td>
                            <td style="text-align: right;border: 1px solid #aaaaaa; font-size:8pt"><b>Jumlah (Orang)</b></td>
                            <td style="border: 1px solid #aaaaaa; font-size:8pt"><b>{{$total}}</b></td>
                            <td style="border: 1px solid #aaaaaa; font-size:8pt"></td>
                            <td style="text-align: right;border: 1px solid #aaaaaa; font-size:8pt"><b>Rp. {{ number_format(str_replace('.', '', $totalRupiah)) }}</b></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                Demikian Kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terimakasih.
            </td>
        </tr>
        <tr>
            <td>
                <table class="table">
                    <tr>
                        <td style="border: 1px solid #aaaaaa; border-bottom: none;">Pemohon,</td>
                        <td colspan="2" style="border: 1px solid #aaaaaa; border-bottom: none;">Menyetujui,</td>
                        <td style="border: 1px solid #aaaaaa; border-bottom: none;">Mengetahui,</td>
                    </tr>
                    <tr>
                        <td style="height: 60px;border: 1px solid #aaaaaa; border-top: none; vertical-align: bottom; padding-bottom: 5px;">_______________</td>
                        <td style="border: 1px solid #aaaaaa; border-top: none; border-right: none; vertical-align: bottom; padding-bottom: 5px;">_______________</td>
                        <td style="border: 1px solid #aaaaaa; border-top: none; border-left: none; vertical-align: bottom; padding-bottom: 5px;">_______________</td>
                        <td style="border: 1px solid #aaaaaa; border-top: none;text-decoration: underline; vertical-align: bottom; padding-bottom: 5px;">Direktur Utama</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
</body>
</html>