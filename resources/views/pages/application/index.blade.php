@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><i class="fa fa-magnifying-glass"></i> <strong>Pilih Pekerjaan</strong></h5>
            </div>
            <div class="col">
                <a type="button" href="javascript:void(0)" id="createNewData" class="btn btn-primary float-right">+ Tambah</a>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="ajaxModal" arial-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="dataForm" name="dataForm" class="form-horizontal">
                        <input type="hidden" name="data_id" id="data_id">
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-1"></i></span>
                                </div>
                                <select type="text" class="form-control" id="posisi" name="posisi" value="">
                                    @foreach ($vacancy as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-2"></i></span>
                                </div>
                                <select type="text" class="form-control" id="posisialt" name="posisialt" value="">
                                    <option value="">Pilih posisi alternatif</option>
                                    @foreach ($vacancy as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-envelope"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Invitation Code (jika ada)" aria-label="undangan"
                                    id="undangan" name="undangan" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-question"></i></span>
                                </div>
                                <select type="text" class="form-control" id="info" name="info" value="">
                                    <option value="">Darimana Anda tahu lowongan ini?</option>
                                    <option value="Jobstreet">Jobstreet</option>
                                    <option value="Teman/saudara">Teman/saudara</option>
                                    <option value="Iklan spanduk/baligo">Iklan spanduk/baligo</option>
                                    <option value="Sosial media">Sosial media</option>
                                    <option value="Website">Website</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3 com-md-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-users"></i></span>
                                </div>
                                <input type="text" class="form-control" aria-label="kerabat" id="kerabat" name="kerabat"
                                    aria-describedby="basic-addon1" placeholder="Kerabat yang bekerja di PT. Dwida Jaya Tama, beserta posisinya (jika ada)">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="btnSave" value="create">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="ajaxModalSchedule" arial-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeadingSchedule"></h4>
                </div>
                <div class="modal-body">
                    <form id="dataForm2" name="dataForm2" class="form-horizontal">
                        <input type="hidden" name="data_id" id="data_id2">
                        <div class="form-row">
                            <div class="input-group mb-6 col-md-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar-day"></i></span>
                                </div>
                                <input type="date" class="form-control" aria-label="dateinvite" id="dateinvite" name="newdateinvite"
                                    aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" id="btnSave2" name="btnSave" value="reschedule">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <table class="table table-striped data-table display nowrap" width="100%">
        <thead>
            <tr>
                <th width="50px">#</th>
                <th>Posisi</th>
                <th>Posisi Alternatif</th>
                <th>Jadwal Interview</th>
                <th>Jam</th>
                <th>Hasil</th>
                <th width="60px"></th>
                <th>Reschedule</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
@stop

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> --}}
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $(".data-table").DataTable({
                // lengthMenu:[[10,25,50,-1],['10', '25', '50', 'Show All']],
                dom: 'frtip',
                // buttons: [
                //     'excel'
                // ],
                // rowReorder: {
                //     selector: 'td:nth-child(2)'
                // },
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: '{{ $x }}',
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0,
                }, ],
                order: [
                    [1, 'asc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'posisi',
                        name: 'posisi',
                        orderable: false,
                    },
                    {
                        data: 'posisialt',
                        name: 'posisialt',
                        orderable: false,
                    },
                    {
                        data: 'jadwalinterview',
                        name: 'jadwalinterview',
                        orderable: false,
                    },
                    {
                        data: 'jadwaljam',
                        name: 'jadwaljam',
                        orderable: false,
                    },
                    {
                        data: 'hasil',
                        name: 'hasil',
                        orderable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'reschedule',
                        name: 'reschedule',
                        searchable: false,
                        orderable: false,
                    },
                ]
            });

            $("#createNewData").click(function() {
                $("#data_id").val('');
                $("#dataForm").trigger("reset");
                $("#modalHeading").html("Tambah Data");
                $("#ajaxModal").modal('show');
            });

            $("#btnSave").click(function(e) {
                e.preventDefault();
                $(this).html('Simpan');

                $.ajax({
                    type: "POST",
                    url: "{{ route('applications.store') }}",
                    data: $("#dataForm").serialize(),
                    dataType: 'json',
                    success: function(data) {
                        $("#dataForm").trigger("reset");
                        $("#ajaxModal").modal('hide');
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error', data);
                        $("#btnSave").html('Simpan');
                    }
                });
            });

            $("#btnSave2").click(function(e) {
                e.preventDefault();
                $(this).html('Simpan');

                $.ajax({
                    type: "POST",
                    url: "{{ route('applications.store') }}",
                    data: $("#dataForm2").serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if(data.error) {
                            alert(data.error);
                        }
                        $("#dataForm2").trigger("reset");
                        $("#ajaxModalSchedule").modal('hide');
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error', data);
                        $("#btnSave2").html('Simpan');
                    }
                });
            });

            $('body').on('click', '.deleteData', function() {
                var data_id = $(this).data("id");
                if (confirm("Apakah Anda yakin?")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('applications.store') }}" + "/" + data_id,
                        success: function(data) {
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error', data);
                        }
                    });
                } else {
                    return false;
                }
            });

            $('body').on('click', '.editData', function() {
                var data_id = $(this).data("id");
                $.get("{{ route('applications.index') }}" + "/" + data_id + "/edit", function(data) {
                    $("#modalHeading").html("Ubah Data");
                    $("#ajaxModal").modal('show');
                    $("#data_id").val(data.id);
                    $("#name").val(data.name);
                    $("#code").val(data.code);
                });
            });

            $('body').on('click', '.reschedule', function() {
                var data_id = $(this).data("id");
                $.get("{{ route('applications.index') }}" + "/" + data_id + "/edit?reschedule=1", function(data) {
                    $("#modalHeadingSchedule").html("Reschedule");
                    $("#ajaxModalSchedule").modal('show');
                    $("#data_id2").val(data.id);
                    $("#dateinvite").val(data.int);
                });
            });
        });
    </script>

@stop
