@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><i class="fa fa-layer-group"></i> <strong>Daftar Lowongan Kerja</strong></h5>
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
                            <div class="input-group mb-3 col-md-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Lowongan pekerjaan" aria-label="name"
                                    id="name" name="name" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-building"></i></span>
                                </div>
                                <select type="text" class="form-control" id="corp" name="corp"
                                    value="">
                                    @foreach ($corps as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-timeline"></i></span>
                                </div>
                                <select type="text" class="form-control" id="dept" name="dept"
                                    value="">
                                    @foreach ($depts as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-power-off"></i></span>
                                </div>
                                <select type="text" class="form-control" id="status" name="status"
                                    value="">
                                        <option value="0">Aktif</option>
                                        <option value="1">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="input-group mb-3 col-md-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-list"></i></span>
                                </div>
                                <textarea id="description" name="description" class="form-control" placeholder="Tulis deskripsi lowongan pekerjaan" rows="7"></textarea>
                            </div>
                            <div class="input-group mb-3 col-md-12">
                                <input type="button" id="addfilePendukung" class="btn btn-success btn-sm" value="Tambah Upload File Pendukung">
                            </div>

                            <div class="input-group mb-3 col-md-12">
                                <div id="divFilePendukung" class="form-row">

                                </div>
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
                <th>Lowongan Pekerjaan</th>
                <th>Unit Bisnis</th>
                <th>Departemen</th>
                <th>Status</th>
                <th></th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
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
                ajax: '{!! route('vacancies.data') !!}',
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
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'corp',
                        name: 'corp'
                    },
                    {
                        data: 'dept',
                        name: 'dept'
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    // {
                    //     data: 'description',
                    //     name: 'description'
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
                    url: "{{ route('vacancies.store') }}",
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
                        url: "{{ route('vacancies.store') }}" + "/" + data_id,
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

            var arr = {!!json_encode($addUpload->toArray())!!};

            $('body').on('click', '.editData', function() {
                var data_id = $(this).data("id");
                $.get("{{ route('vacancies.index') }}" + "/" + data_id + "/edit", function(data) {
                    $("#modalHeading").html("Ubah Data");
                    $("#ajaxModal").modal('show');
                    $('#divFilePendukung .input-group.mb-3.col-md-12').remove();
                    $("#data_id").val(data.id);
                    $("#name").val(data.name);
                    $("#dept").val(data.dept);
                    $("#corp").val(data.corp);
                    $("#description").val(data.description);
                    $("#status").val(data.status);

                    if(Object.keys(data.vacancies_additional_upload).length > 0)
                    {
                        for (const row of Object.keys(data.vacancies_additional_upload))
                        {
                            var d = data.vacancies_additional_upload[row];
                            var sel = $('<select>', {'class' : 'form-control', 'type' : 'text', 'name' : 'pendukung['+d.id+']'});

                            $(arr).each(function() {
                                if (this.id == d.additional_upload_id) {
                                    sel.append($("<option>").attr({'value': this.id, 'selected': 'selected'}).text(this.text));
                                } 
                                else {
                                    sel.append($("<option>").attr('value',this.id).text(this.text));
                                }
                            });

                            var div2 = $('<div>', { class: 'input-group mb-3 col-md-12', style : 'left: 0px;' });
                            var div3 = $('<div>', { class: 'input-group-prepend' });
                            var span = $('<span>', { class : 'input-group-text'}).append($('<i>', {class : 'fa fa-file'}));
                            var del = $('<button>', { class: 'btn btn-sm btn-danger delete', value: 'X', type: 'button'}).text('Delete');
                            div2.append(div3.append(span).append(sel).append('&nbsp;&nbsp;&nbsp;').append(del)).appendTo($('#divFilePendukung'));
                        }
                    }

                    var elements = $('.delete');
                    for (var i = 0; i < elements.length; i++) { 
                        elements[i].addEventListener('click', funcDelete, false);
                    }
                });
            });

            function funcDelete()
            {
                var ele = $(this).closest('.input-group.mb-3.col-md-12');
                ele.remove();
            }

            $("#addfilePendukung").on("click", function(){
                var sel = $('<select>', {'class' : 'form-control', 'type' : 'text', 'name' : 'pendukung[]'});

                $(arr).each(function() {
                    sel.append($("<option>").attr('value',this.id).text(this.text));
                });

                var div2 = $('<div>', { class: 'input-group mb-3 col-md-12', style : 'left: 0px;' });
                var div3 = $('<div>', { class: 'input-group-prepend' });
                var span = $('<span>', { class : 'input-group-text'}).append($('<i>', {class : 'fa fa-file'}));
                var del = $('<button>', { class: 'btn btn-sm btn-danger delete', value: 'X', type: 'button'}).text('Delete');
                div2.append(div3.append(span).append(sel).append('&nbsp;&nbsp;&nbsp;').append(del)).appendTo($('#divFilePendukung'));

                var elements = $('.delete');
                for (var i = 0; i < elements.length; i++) { 
                    elements[i].addEventListener('click', funcDelete, false);
                }
            });

        });
    </script>

@stop
