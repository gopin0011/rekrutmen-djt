@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><i class="fa fa-users-gear"></i> <strong>Daftar Pelamar</strong></h5>
            </div>
        </div>
    </div>
@stop

@section('content')
    <table class="table table-striped data-table display nowrap" width="100%">
        <thead>
            <tr>
                <th width="50px">#</th>
                <th>Pelamar</th>
                <th>Email</th>
                <th><i class="fa fa-user"></i></th>
                <th><i class="fa fa-users"></i></th>
                <th><i class="fa fa-graduation-cap"></i></th>
                <th><i class="fa fa-briefcase"></i></th>
                <th><i class="fa fa-people-roof"></i></th>
                <th><i class="fa fa-signature"></i></th>
                <th><i class="fa fa-upload"></i></th>
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
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: '{!! route('applicants.data') !!}',
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'profile',
                        name: 'profile',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'family',
                        name: 'family',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'study',
                        name: 'study',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'career',
                        name: 'career',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'activity',
                        name: 'activity',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'ref',
                        name: 'ref',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'doc',
                        name: 'doc',
                        searchable: false,
                        orderable: false,
                    },
                ]
            });

            $('body').on('click', '#editProfile', function() {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/profiles/" + data_id;
            });

            $('body').on('click', '#editFamily', function() {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/families/" + data_id;
            });

            $('body').on('click', '#editStudy', function() {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/studies/" + data_id;
            });

            $('body').on('click', '#editCareer', function() {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/careers/" + data_id;
            });

            $('body').on('click', '#editActivity', function() {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/activities/" + data_id;
            });

            $('body').on('click', '#editRef', function() {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/references/" + data_id;
            });

            $('body').on('click', '#editDoc', function() {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/documents/" + data_id;
            });
        });
    </script>

@stop
