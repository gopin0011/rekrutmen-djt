@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><i class="fa fa-list-check"></i> <strong>Daftar Interview</strong></h5>
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
                                            class="fa fa-calendar-day"></i></span>
                                </div>
                                <input type="date" class="form-control" aria-label="jadwalinterview"
                                    id="jadwalinterview" name="jadwalinterview" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-users"></i></span>
                                </div>
                                <input type="text" class="form-control" aria-label="kerabat" id="kerabat" name="kerabat"
                                    aria-describedby="basic-addon1" placeholder="Kerabat">
                            </div>
                        </div>
                        <hr>
                        <h6><b>Hasil Interview & Tanggal Bergabung</b></h6>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-pen"></i></span>
                                </div>
                                <select type="text" class="form-control" id="hasil" name="hasil">
                                    <option value="">Hasil</option>
                                    <option value="0">Tidak diterima</option>
                                    <option value="1">Diterima</option>
                                    <option value="2">Hold</option>
                                </select>
                            </div>
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-check"></i></span>
                                </div>
                                <input type="date" class="form-control" aria-label="jadwalgabung"
                                    id="jadwalgabung" name="jadwalgabung" aria-describedby="basic-addon1">
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
    <table class="table table-striped data-table display nowrap" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th></th>
                <th>Pelamar</th>
                <th>Interview</th>
                <th>NIK</th>
                <th>Posisi</th>
                <th>Tanggal Lahir</th>
                <th>Usia</th>
                <th>Alamat</th>
                <th>Kontak</th>
                <th>Email</th>
                <!-- <th>Pendidikan Terakhir</th>
                <th>Sekolah</th>
                <th>Posisi Terakhir</th>
                <th>Perusahaan</th>
                <th>Referensi</th>
                <th>Nilai DISC</th>
                <th>Nilai IST</th>
                <th>Nilai CFIT</th>
                <th>Nilai Army alpha</th>
                <th>Nilai Papikostik</th>
                <th>Nilai Kreplin</th>
                <th>Interview HR</th>
                <th>Interview User</th>
                <th>Interview Manajemen</th>
                <th>Hasil Akhir</th>
                <th>Tanggal Gabung</th>
                <th>Undangan</th> -->
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
            function newexportaction(e, dt, button, config) {
                var self = this;
                var oldStart = dt.settings()[0]._iDisplayStart;
                dt.one('preXhr', function(e, s, data) {
                    // Just this once, load all data from the server...
                    data.start = 0;
                    data.length = 2147483647;
                    dt.one('preDraw', function(e, settings) {
                        // Call the original action function
                        if (button[0].className.indexOf('buttons-copy') >= 0) {
                            $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button,
                                config);
                        } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                            $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt,
                                    button, config) :
                                $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt,
                                    button, config);
                        } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                            $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button,
                                    config) :
                                $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button,
                                    config);
                        } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                            $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button,
                                    config) :
                                $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button,
                                    config);
                        } else if (button[0].className.indexOf('buttons-print') >= 0) {
                            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                        }
                        dt.one('preXhr', function(e, s, data) {
                            // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                            // Set the property to what it was before exporting.
                            settings._iDisplayStart = oldStart;
                            data.start = oldStart;
                        });
                        // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                        setTimeout(dt.ajax.reload, 0);
                        // Prevent rendering of the full data to the DOM
                        return false;
                    });
                });
                // Requery the server with the new one-time export settings
                dt.ajax.reload();
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $(".data-table").DataTable({
                // lengthMenu:[[10,25,50,-1],['10', '25', '50', 'Show All']],
                dom: 'Bfrtip',
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
                buttons: [{
                    extend: 'excel',
                    text: 'Cetak ke Excel',
                    // titleAttr: 'Excel',
                    action: newexportaction
                }, ],
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0,
                }, ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'jadwalinterview',
                        name: 'jadwalinterview',
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                    },
                    {
                        data: 'posisi',
                        name: 'posisi',
                    },
                    {
                        data: 'lahir',
                        name: 'lahir',
                    },
                    {
                        data: 'usia',
                        name: 'usia',
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                    },
                    {
                        data: 'kontak',
                        name: 'kontak',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    // {
                    //     data: 'tingkat',
                    //     name: 'tingkat',
                    // },
                    // {
                    //     data: 'sekolah',
                    //     name: 'sekolah',
                    // },
                    // {
                    //     data: 'jabatan',
                    //     name: 'jabatan',
                    // },
                    // {
                    //     data: 'perusahaan',
                    //     name: 'perusahaan',
                    // },
                    // {
                    //     data: 'referensi',
                    //     name: 'referensi',
                    // },
                    // {
                    //     data: 'disc',
                    //     name: 'disc',
                    // },
                    // {
                    //     data: 'ist',
                    //     name: 'ist',
                    // },
                    // {
                    //     data: 'cfit',
                    //     name: 'cfit',
                    // },
                    // {
                    //     data: 'army',
                    //     name: 'army',
                    // },
                    // {
                    //     data: 'papi',
                    //     name: 'papi',
                    // },
                    // {
                    //     data: 'krep',
                    //     name: 'krep',
                    // },
                    // {
                    //     data: 'int_hr',
                    //     name: 'int_hr',
                    // },
                    // {
                    //     data: 'int_user',
                    //     name: 'int_user',
                    // },
                    // {
                    //     data: 'int_mana',
                    //     name: 'int_mana',
                    // },
                    // {
                    //     data: 'hasil',
                    //     name: 'hasil',
                    // },
                    // {
                    //     data: 'tanggalgabung',
                    //     name: 'tanggalgabung',
                    // },
                    // {
                    //     data: 'undangan',
                    //     name: 'undangan',
                    // },
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
                    url: "{{ route('applications.storeadmin') }}",
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
                    $("#posisi").val(data.posisi);
                    $("#posisialt").val(data.posisialt);
                    $("#jadwalinterview").val(data.jadwalinterview);
                    $("#jadwalgabung").val(data.jadwalgabung);
                    $("#hasil").val(data.hasil);
                    $("#kerabat").val(data.kerabat);
                });
            });
        });
    </script>

@stop
