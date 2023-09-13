@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><i class="fa fa-list"></i> <strong>Overtimes</strong></h5>
            </div>
            <div class="col-md-3">
                <!-- <h5><i class="fa fa-upload"></i> <strong>Unggah XLS</strong> -->
                <a type="button" href="javascript:void(0)" id="createNewData" class="btn btn-primary float-right">Import Excel</a>
            </div>
        </div>
            
    </div>
    <div class="modal fade" id="ajaxModal" arial-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="dataForm" name="dataForm" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <div class="custom-file">
                                <input id="file" type="file" name="file" accept="application/xlsx">
                                <p style="font-size: 8pt">(Ukuran Maksimal: 4 MB)</p>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="btnSave" value="create">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
<form method="GET" action="{{route('overtimes.view.form-detail', ['tanggalspl' => $tanggalspl])}}" id="form">

@csrf
<table class="" style="margin: 10px 0px">
        <tr>
            <td>
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="10">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-1 col-form-label">Filter</label>
                                    <div class="col-sm-11">
                                        <select name="filter" id="filter" class="form-control col-md-3">
                                            <option value="0" @if('0' == $filter) selected @endif>All</option>
                                            @foreach ($divisi as $key => $row)
                                            <option value="{{$row}}" @if($row == $filter) selected @endif>{{$key}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
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
                                    <td style="text-align: right;font-size:10pt"><input type="text" class="form-control" name="masuk[{{$people->id}}]" value="{{$people->masuk}}" placeholder="hh:ii"></td>
                                    <td style="text-align: right;font-size:10pt"><input type="text" class="form-control" name="pulang[{{$people->id}}]" value="{{$people->pulang}}" placeholder="hh:ii"></td>
                                    <td style="text-align: right;font-size:10pt">
                                        <select name="is_umak_cut[{{$people->id}}]" class="form-control">
                                        <option value="" @if($people->is_umak_cut == null || $people->is_umak_cut == "") selected @endif></option>
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
                            <td colspan="11"><input type="button" value="Simpan" class="btn btn-success" name="save" id="save">&nbsp;<a href="{{route('overtimes.print.form-detail', ['tanggalspl' => $tanggalspl])}}" target="_blank" class="btn btn-primary">Print</a>&nbsp;<a href="{{route('exportDetailSpl', ['tanggalspl' => $tanggalspl])}}" target="_blank" class="btn btn-warning">Export To Excel</a></td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>
    </table>
</form>    
@endsection

@section('js')
<script type="text/javascript">
    $("#filter").change(function(){
        $("#form").attr({'method':'GET', 'action':"{{route('overtimes.view.form-detail', ['tanggalspl' => $tanggalspl])}}"});
        $("#form").submit();
    });

    $("#save").click(function(){
        $("#form").attr({'method':'POST', 'action':"{{route('overtimes.post.form-detail', ['tanggalspl' => $tanggalspl])}}"});
        $("#form").submit();
    });

    $('#createNewData').click(function(){
        $("#ajaxModal").modal('show');
    });

    $('body').on('submit', '#dataForm', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('importDetailSpl', ['tanggalspl' => $tanggalspl]) }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                location.reload();
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
</script>
@endsection