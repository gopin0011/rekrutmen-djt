@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><i class="fa fa-earth-asia"></i> <strong>Kemampuan Bahasa</strong></h5>
            </div>
            <div class="col float-right">
                <a type="button" href="javascript:void(0)" id="createNewData" class="btn btn-primary float-right">+
                    Tambah</a>
                </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-xl" id="ajaxModal" arial-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="dataForm" name="dataForm" class="form-horizontal">
                        <input type="hidden" name="data_id" id="data_id">
                        <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->admin == 0 ? Auth::user()->id : $id }}">
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-earth-asia"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Bahasa" aria-label="bahasa"
                                    id="bahasa" name="bahasa" aria-describedby="basic-addon1" required>
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-comments"></i></span>
                                </div>
                                <select type="text" class="form-control" id="bicara" name="bicara">
                                        <option value="Dasar">Dasar</option>
                                        <option value="Menengah">Menengah</option>
                                        <option value="Mahir">Mahir</option>
                                </select>
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-book-open"></i></span>
                                </div>
                                <select type="text" class="form-control" id="baca" name="baca">
                                        <option value="Dasar">Dasar</option>
                                        <option value="Menengah">Menengah</option>
                                        <option value="Mahir">Mahir</option>
                                </select>
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-pen"></i></span>
                                </div>
                                <select type="text" class="form-control" id="tulis" name="tulis">
                                        <option value="Dasar">Dasar</option>
                                        <option value="Menengah">Menengah</option>
                                        <option value="Mahir">Mahir</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-note-sticky"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Catatan" aria-label="catatan"
                                    id="catatan" name="catatan" aria-describedby="basic-addon1" required>
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
                <th width="60px"></th>
                <th>Bahasa</th>
                <th>Bicara</th>
                <th>Baca</th>
                <th>Tulis</th>
                <th>Catatan</th>
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
                ajax: '{!! route('applicant_languages.data') !!}',
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
                        data: 'bahasa',
                        name: 'bahasa'
                    },
                    {
                        data: 'bicara',
                        name: 'bicara'
                    },
                    {
                        data: 'baca',
                        name: 'baca'
                    },
                    {
                        data: 'tulis',
                        name: 'tulis'
                    },
                    {
                        data: 'catatan',
                        name: 'catatan'
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
                    url: "{{ route('applicant_languages.store') }}",
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
                        url: "{{ route('applicant_languages.store') }}" + "/" + data_id,
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
                $.get("{{ route('applicant_languages.index') }}" + "/" + data_id + "/edit", function(data) {
                    $("#modalHeading").html("Ubah Data");
                    $("#ajaxModal").modal('show');
                    $("#data_id").val(data.id);
                    $("#bahasa").val(data.bahasa);
                    $("#bicara").val(data.bicara);
                    $("#baca").val(data.baca);
                    $("#tulis").val(data.tulis);
                    $("#catatan").val(data.catatan);
                });
            });
        });
    </script>
@stop
