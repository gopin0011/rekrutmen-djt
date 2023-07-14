@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><i class="fa fa-list"></i> <strong>Overtimes</strong></h5>
            </div>
        </div>
    </div>
@stop

@section('content')
<form method="POST">
@csrf
<table class="" style="margin: 10px 0px">
        <tr>
            <td>
                <table class="table">
                    <thead>
                        <tr>
                            <th style="font-size:10pt">No.</th>
                            <th style="font-size:10pt">Divisi</th>
                            <th style="font-size:10pt">Nik</th>
                            <th style="font-size:10pt">Nama</th>
                            <th style="font-size:10pt">Jabatan</th>
                            <th style="font-size:10pt">Waktu Kerja</th>
                            <th style="font-size:10pt">Tanggal</th>
                            <th style="font-size:10pt">Hari</th>
                            <th style="font-size:10pt">Masuk</th>
                            <th style="font-size:10pt">Pulang</th>
                            <th style="font-size:10pt">Potongan Umak</th>
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
                                    <td style="font-size:10pt"><input type="hidden" name="id[]" value="{{$people->id}}">{{ $no++ }}</td>
                                    <td style="text-align: left;font-size:10pt">{{$row->kode}} - {{$row->nama}}</td>
                                    <td style="font-size:10pt">{{$people->nik}}</td>
                                    <td style="text-align: left;font-size:10pt">{{$people->nama}}</td>
                                    <td style="text-align: right;font-size:10pt">{{$people->jabatan}}</td>
                                    <td style="text-align: right;font-size:10pt">{{$value->waktu}}</td>
                                    <td style="text-align: right;font-size:10pt">{{ \Carbon\Carbon::parse($value->tanggalspl)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('j F, Y') }}</td>
                                    <td style="text-align: right;font-size:10pt">{{ \Carbon\Carbon::parse($value->tanggalspl)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('l') }}</td>
                                    <td style="text-align: right;font-size:10pt"><input type="text" class="form-control" name="masuk[{{$people->id}}]" value="{{$people->masuk}}" placeholder="hh:ii:ss"></td>
                                    <td style="text-align: right;font-size:10pt"><input type="text" class="form-control" name="pulang[{{$people->id}}]" value="{{$people->pulang}}" placeholder="hh:ii:ss"></td>
                                    <td style="text-align: right;font-size:10pt">
                                        <select name="is_umak_cut[{{$people->id}}]" class="form-control">
                                            <option value="1" @if($people->is_umak_cut == "1") selected @endif>Ya</option>
                                            <option value="0" @if($people->is_umak_cut == "0") selected @endif>Tidak</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        @php
                            
                        @endphp
                        @endforeach

                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="11"><input type="submit" value="Simpan" class="btn btn-success">&nbsp;<a href="{{route('overtimes.print.form-detail', ['tanggalspl' => $tanggalspl])}}" target="_blank" class="btn btn-primary">Print</a></td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
</form>    
@endsection