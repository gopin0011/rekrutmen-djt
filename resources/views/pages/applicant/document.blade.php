@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><i class="fa fa-upload"></i> <strong>Unggah CV</strong></h5>
            </div>
            <div class="col">
                <a type="button" href="javascript:void(0)" id="createNewData" class="btn btn-primary float-right">Unggah</a>
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
                        <input type="hidden" name="data_id" id="data_id">
                        <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->admin == 0 ? Auth::user()->id : $id }}">
                        <div class="form-group">
                            <div class="custom-file">
                                <input id="file" type="file" name="file" accept="application/pdf">
                                <p style="font-size: 8pt">(Ukuran Maksimal: 4 MB, Format: PDF)</p>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="btnSave" value="create">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxModalAdd" arial-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeadingAdd"></h4>
                </div>
                <div class="modal-body">
                    <form id="dataForm2" name="dataForm" class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" id="useridAdditional" value="">
                        <input type="hidden" name="vacancy_id" id="vacancy_id" value="">
                        <input type="hidden" name="additional_upload_id" id="additional_upload_id" value="">
                        <div class="form-group">
                            <div class="custom-file">
                                <input id="file" type="file" name="file" accept="application/pdf">
                                <p style="font-size: 8pt">(Ukuran Maksimal: 4 MB, Format: PDF)</p>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="btnSave2" value="create">Simpan</button>
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
                <th>Dokumen</th>
                <th width="60px"></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <table class="table table-striped data-table2 display nowrap" width="100%">
        <thead>
            <tr>
                <th>Dokumen Pendukung</th>
                <th width="60px"></th>
            </tr>
        </thead>
        <tbody>
        @if(count($applications))
        @foreach($applications as $row) 
            <tr>
                <td>{{$row->vacancy->name}}</td>
                <td></td>
            </tr>
            @if(count($row->vacancy->vacanciesAdditionalUpload))
            @foreach($row->vacancy->vacanciesAdditionalUpload as $doc)
            <tr>
                <td>{{$loop->index+1}}. {{$doc->additionalUpload->text}}</td>
                <td class="file-pendukung" data-userid="{{$row->user_id}}" data-vacancyid="{{$row->posisi}}" data-additionalupload="{{$doc->additional_upload_id}}">
                    
                </td>
            </tr>
            @endforeach
            @endif
        @endforeach
        @endif
        </tbody>
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
            $('body').on('submit', '#dataForm2', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('applicant_documents.additional.store') }}",
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

            $('body').on('click', '.del', function() {
                var data_id = $(this).data("id");
                if (confirm("Apakah Anda yakin?")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('applicant_documents.additional.delete', [':id']) }}".replace(':id', data_id),
                        success: function(data) {
                            location.reload();
                        },
                        error: function(data) {
                            console.log('Error', data);
                        }
                    });
                } else {
                    return false;
                }
            });

            const getData = async (url) => {
                const request = await fetch(url);
                const d = await request.json();
                return d;
            };
            
            var additional = $(".file-pendukung");

            function showModal()
            {
                var title = $(this).data('title');
                $("#modalHeadingAdd").html(title);
                var user_id = $(this).data('userid');
                $('#useridAdditional').val(user_id);
                var vacancy_id = $(this).data('vacancyid');
                $('#vacancy_id').val(vacancy_id);
                var additional_upload_id = $(this).data('additionaluploadid');
                $('#additional_upload_id').val(additional_upload_id);
                $("#dataForm2").trigger("reset");
                $("#ajaxModalAdd").modal('show');
            }

            $(additional).each(function() {
                var userid = $(this).data("userid");
                var vacancyid = $(this).data("vacancyid");
                var vacAdditionalUpload = $(this).data("additionalupload");
                var url = "{{ route('applicant_documents.additional.data', [':userid', ':vacancyid', ':additionalupload']) }}".replace(':userid', userid).replace(':vacancyid', vacancyid).replace(':additionalupload', vacAdditionalUpload);
                getData(url).then(result => {
                    if(!result.ApplicantAdditionalDocument) {
                        var div = $('<div>', {class: 'btn-group'});
                        var upp = $('<a>', {'data-toggle': 'tooltip', 'data-userid': result.userid, 'data-vacancyid': result.vacancyid, 'data-additionaluploadid': result.additionaluploadid, 'data-title' : result.title, 'data-original-title' : 'Edit', 'class': 'edit btn btn-primary btn-sm upp'});
                        var iUpp = upp.append($('<i>', {class: 'fa fa-upload'}));
                        $(this).append(div.append(iUpp));
                        upp.click(showModal);
                    } 
                    else {
                        var url2 = "{{route('storage.doc', [':folder',':filename'])}}".replace(':folder', 'additional').replace(':filename', result.ApplicantAdditionalDocument.file+'.pdf');
                        var div = $('<div>', {class: 'btn-group'});
                        var see = $('<a>', {'href': url2, 'target': '_blank', 'data-toggle': 'tooltip', 'data-id': '', 'data-original-title' : 'Edit', 'class': 'edit btn btn-primary btn-sm see'});
                        var iSee = see.append($('<i>', {class: 'fa fa-eye'}));
                        var del = $('<a>', {'data-toggle': 'tooltip', 'data-id': result.ApplicantAdditionalDocument.id, 'data-original-title' : 'Edit', 'class': 'edit btn btn-danger btn-sm del'});
                        var iDel = del.append($('<i>', {class: 'fa fa-trash'}));
                        $(this).append(div.append(iSee).append(iDel));
                    }
                });
            });
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $(".data-table").DataTable({
                dom: 't',
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: '{{ $dt }}',
                columns: [
                    {
                        data: 'name',
                        name: 'name',
                        orderable: false,
                    },
                    {
                        data: 'action',
                        name: 'action',
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

            

            $('body').on('submit', '#dataForm', function(e) {
                e.preventDefault();
                var actionType = $('#btnSave').val();
                $('#btnSave').html('Simpan');
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('applicant_documents.store') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('#dataForm').trigger("reset");
                        $('#ajaxModal').modal('hide');
                        $('#btnSave').html('Simpan');
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#btnSave').html('Simpan');
                    }
                });
            });
            $('body').on('click', '.deleteData', function() {
                var data_id = $(this).data("id");
                if (confirm("Apakah Anda yakin?")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('applicant_documents.store') }}" + "/" + data_id,
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
        });
    </script>
@stop
