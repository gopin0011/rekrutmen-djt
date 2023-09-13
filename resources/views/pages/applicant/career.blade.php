@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><i class="fa fa-briefcase"></i> <strong>Riwayat Pekerjaan</strong></h5>
            </div>
            <div class="col float-right">
                <a type="button" href="javascript:void(0)" id="createNewData" class="btn btn-primary float-right">+
                    Tambah</a>
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
                        <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->admin == 0 ? Auth::user()->id : $id }}">
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-8">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-building"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Nama perusahaan" aria-label="perusahaan"
                                    id="perusahaan" name="perusahaan" aria-describedby="basic-addon1" required>
                            </div>
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-timeline"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Jabatan" aria-label="jabatan"
                                    id="jabatan" name="jabatan" aria-describedby="basic-addon1" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="input-group mb-3 col-md-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-location-pin"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Alamat" aria-label="alamat"
                                    id="alamat" name="alamat" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-play"></i></span>
                                </div>
                                <input type="month" class="form-control" aria-label="masuk"
                                    id="masuk" name="masuk" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-stop"></i></span>
                                </div>
                                <input type="month" class="form-control" aria-label="keluar"
                                    id="keluar" name="keluar" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-sack-dollar"></i></span>
                                </div>
                                <input type="number" class="form-control" placeholder="Gaji" aria-label="gaji"
                                    id="gaji" name="gaji" aria-describedby="basic-addon1" required>
                            </div>
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-certificate"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Prestasi" aria-label="prestasi"
                                    id="prestasi" name="prestasi" aria-describedby="basic-addon1" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="input-group mb-3 col-md-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-hammer"></i></span>
                                </div>
                                <textarea class="form-control" placeholder="Pekerjaan" aria-label="pekerjaan"
                                    id="pekerjaan" name="pekerjaan" aria-describedby="basic-addon1"></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="input-group mb-3 col-md-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-right-from-bracket"></i></span>
                                </div>
                                <textarea class="form-control" placeholder="Alasan resign" aria-label="alasan"
                                    id="alasan" name="alasan" aria-describedby="basic-addon1"></textarea>
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
@if($mustUpload)
Silahkan Unggah CV / Berkas Terlebih Dahulu
@else
    <table class="table table-striped data-table display nowrap" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th width="60px"></th>
                <th>Perusahaan</th>
                <th>Alamat</th>
                <th>Jabatan</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Gaji</th>
                <th>Pekerjaan</th>
                <th>Prestasi</th>
                <th>Alasan</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <p>* Masukkan dari yang paling terakhir</p>
@endif
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
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />
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
                dom: 'frtip',
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: '{{ $dt }}',
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0,
                }, ],
                order: [
                    [2, 'asc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                    },
                    {
                        data: 'perusahaan',
                        name: 'perusahaan'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan'
                    },
                    {
                        data: 'masuk',
                        name: 'masuk'
                    },
                    {
                        data: 'keluar',
                        name: 'keluar'
                    },
                    {
                        data: 'gaji',
                        name: 'gaji'
                    },
                    {
                        data: 'pekerjaan',
                        name: 'pekerjaan'
                    },
                    {
                        data: 'prestasi',
                        name: 'prestasi'
                    },
                    {
                        data: 'alasan',
                        name: 'alasan'
                    },
                ],
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
                    url: "{{ route('applicant_careers.store') }}",
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
                        url: "{{ route('applicant_careers.store') }}" + "/" + data_id,
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
                $.get("{{ route('applicant_careers.index') }}" + "/" + data_id + "/edit", function(data) {
                    $("#modalHeading").html("Ubah Data");
                    $("#ajaxModal").modal('show');
                    $("#data_id").val(data.id);
                    $("#perusahaan").val(data.perusahaan);
                    $("#jabatan").val(data.jabatan);
                    $("#alamat").val(data.alamat);
                    $("#gaji").val(data.gaji);
                    $("#prestasi").val(data.prestasi);
                    $("#pekerjaan").val(data.pekerjaan);
                    $("#alasan").val(data.alasan);
                    $("#masuk").val(data.masuk);
                    $("#keluar").val(data.keluar);
                });
            });
        });
    </script>
@stop
