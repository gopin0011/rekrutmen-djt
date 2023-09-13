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
    <table id="table" class="table table-striped data-table display nowrap" width="100%">
        <thead>
            <tr>
                <td colspan="9">
                    <input type="text" placeholder="Search Name Or Email" class="form-control" id="search" aria-label="search" aria-describedby="basic-addon1">
                </td>
            </tr>
            <tr>
                <th width="50px">#</th>
                <th>Pelamar</th>
                <th>Email</th>
                <th>Info</th>
                <!-- <th><i class="fa fa-user"></i></th>
                <th><i class="fa fa-users"></i></th>
                <th><i class="fa fa-graduation-cap"></i></th>
                <th><i class="fa fa-briefcase"></i></th>
                <th><i class="fa fa-people-roof"></i></th>
                <th><i class="fa fa-signature"></i></th>
                <th><i class="fa fa-upload"></i></th> -->
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right" style="text-align: right;">
                    <div aria-label="Page navigation example">
                        <ul class="pagination">
                        </ul>
                    </div>
                </td>
            </tr>
        </tfoot>
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
            // var table = $(".data-table").DataTable({
            //     responsive: true,
            //     serverSide: true,
            //     processing: true,
            //     ajax: '{!! route('applicants.data') !!}',
            //     columnDefs: [{
            //         searchable: false,
            //         orderable: false,
            //         targets: 0,
            //     }, ],
            //     order: [
            //         [1, 'asc']
            //     ],
            //     columns: [{
            //             data: 'DT_RowIndex',
            //             name: 'DT_RowIndex'
            //         },
            //         {
            //             data: 'name',
            //             name: 'name'
            //         },
            //         {
            //             data: 'email',
            //             name: 'email'
            //         },
            //         {
            //             data: 'profile',
            //             name: 'profile',
            //             searchable: false,
            //             orderable: false,
            //         },
            //         {
            //             data: 'family',
            //             name: 'family',
            //             searchable: false,
            //             orderable: false,
            //         },
            //         {
            //             data: 'study',
            //             name: 'study',
            //             searchable: false,
            //             orderable: false,
            //         },
            //         {
            //             data: 'career',
            //             name: 'career',
            //             searchable: false,
            //             orderable: false,
            //         },
            //         {
            //             data: 'activity',
            //             name: 'activity',
            //             searchable: false,
            //             orderable: false,
            //         },
            //         {
            //             data: 'ref',
            //             name: 'ref',
            //             searchable: false,
            //             orderable: false,
            //         },
            //         {
            //             data: 'doc',
            //             name: 'doc',
            //             searchable: false,
            //             orderable: false,
            //         },
            //     ]
            // });

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

            function editProfile()
            {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/profiles/" + data_id;
            }

            function editFamily()
            {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/families/" + data_id;
            }

            function editStudy()
            {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/studies/" + data_id;
            }

            function editCareer()
            {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/careers/" + data_id;
            }

            function editActivity()
            {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/activities/" + data_id;
            }

            function editRef()
            {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/references/" + data_id;
            }

            function editDoc()
            {
                var data_id = $(this).data("id");
                window.location.href = "{{ route('mod.edit') }}" + "/documents/" + data_id;
            }

            const getData = async (url) => {
                const request = await fetch(url);
                const d = await request.json();

                return d;
            };

            getData("{{route('applicants.data')}}").then(result => { makeStruct(result); });

            var paginationFunc = function()
            {
                var d = JSON.parse(this.getAttribute("data-attribute"));

                getData(d).then(result => { makeStruct(result); });

                return false;
            };

            function makeStruct(d)
            {
                // add to table
                $('#table').find('tbody').empty();

                if(Object.keys(d.paginator.data).length > 0)
                {
                    for (const row of Object.keys(d.paginator.data))
                    {
                        var data = d.paginator.data[row];

                        if(!data.applicant_profile) {
                            var $profile = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-danger btn-sm profile' });
                        } else {
                            var $profile = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-primary btn-sm profile' });
                        }
                        var iprofile = $('<i>', { class: 'fa fa-user' });

                        if(data.applicant_family.length == 0) {
                            var $family = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-danger btn-sm family' });
                        } else {
                            var $family = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-primary btn-sm family' });
                        }
                        var ifamily = $('<i>', { class: 'fa fa-users' });

                        if(data.applicant_study.length == 0) {
                            var $study = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-danger btn-sm study' });
                        } else {
                            var $study = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-primary btn-sm study' });
                        }
                        var istudy = $('<i>', { class: 'fa fa-graduation-cap' });

                        if(data.applicant_career.length == 0) {
                            var $career = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-danger btn-sm career' });
                        } else {
                            var $career = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-primary btn-sm career' });
                        }
                        var icareer = $('<i>', { class: 'fa fa-briefcase' });

                        if(data.applicant_activity.length == 0) {
                            var $activity = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-danger btn-sm activity' });
                        } else {
                            var $activity = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-primary btn-sm activity' });
                        }
                        var iactivity = $('<i>', { class: 'fa fa-people-roof' });

                        if(data.applicant_reference.length == 0) {
                            var $ref = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-danger btn-sm refer' });
                        } else {
                            var $ref = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-primary btn-sm refer' });
                        }
                        var iref = $('<i>', { class: 'fa fa-signature' });

                        if(data.applicant_document.length == 0) {
                            var $doc = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-danger btn-sm doc' });
                        } else {
                            var $doc = $('<a>', { 'data-toggle':'tooltip', 'data-id': data.id, 'data-original-title':'Edit', 'class': 'edit btn btn-primary btn-sm doc' });
                        }
                        var idoc = $('<i>', { class: 'fa fa-upload' });

                        $('#table').find('tbody').append("<tr><td class='text-center'>"+(parseInt(data.id))+"</td><td>"+data.name+"</td><td>"+data.email+"</td><td id='td"+row+"'></td></tr>");
                        $('<div>', { class: 'btn-group' }).append($profile.append(iprofile)).append($family.append(ifamily)).append($study.append(istudy)).append($career.append(icareer)).append($activity.append(iactivity)).append($ref.append(iref)).append($doc.append(idoc)).appendTo($('#td'+row));

                        // var $btn_print = $('<button>', { type: 'button', 'data-id': data_id, class: 'btn btn-info btn-sm mb-2 float-right print' });
                        // var i = $('<i>', { class: 'fas fa-print' });
                        // var $btn_excel = $('<button>', { type: 'button', 'data-id': data_id, class: 'btn btn-success btn-sm mb-2 float-right excel' });
                        // var i2 = $('<i>', { class: 'fas fa-file' });

                        // $('#table').find('tbody').append("<tr class='tr-"+row+"' style='display: none;'><td></td><td>* "+data.items[item].name+"</td><td>"+data.items[item].exp_date+"</td><td>"+data.items[item].qty+"</td><td></td><td></td><td></td></tr>");
                    }
                }
                else 
                {
                    $('#table').find('tbody').append("<tr><td colspan='10' class='text-center'>No Result</td></tr>");
                }

                var elements = $('.profile'); //document.getElementsByClassName("profile");
                for (var i = 0; i < elements.length; i++) { 
                    elements[i].addEventListener('click', editProfile, false);
                }

                var elements = $('.family'); //document.getElementsByClassName("profile");
                for (var i = 0; i < elements.length; i++) { 
                    elements[i].addEventListener('click', editFamily, false);
                }

                var elements = $('.study'); //document.getElementsByClassName("profile");
                for (var i = 0; i < elements.length; i++) { 
                    elements[i].addEventListener('click', editStudy, false);
                }

                var elements = $('.career'); //document.getElementsByClassName("profile");
                for (var i = 0; i < elements.length; i++) { 
                    elements[i].addEventListener('click', editCareer, false);
                }

                var elements = $('.activity'); //document.getElementsByClassName("profile");
                for (var i = 0; i < elements.length; i++) { 
                    elements[i].addEventListener('click', editActivity, false);
                }

                var elements = $('.refer'); //document.getElementsByClassName("profile");
                for (var i = 0; i < elements.length; i++) { 
                    elements[i].addEventListener('click', editRef, false);
                }

                var elements = $('.doc'); //document.getElementsByClassName("profile");
                for (var i = 0; i < elements.length; i++) { 
                    elements[i].addEventListener('click', editDoc, false);
                }
                
                // make pagination
                var pagination = $('.pagination');
                pagination.empty();

                for (const row of Object.keys(d.paginator.links))
                {
                    var li = $('<li />', {class: 'page-item'});
                    if(d.paginator.links[row].active) li.addClass('active');
                    var button = $('<button />', {class: 'page-link btn-sm', type: 'button', 'data-url': d.paginator.links[row].url, 'data-attribute' : JSON.stringify(d.paginator.links[row].url)});
                    if(!d.paginator.links[row].url) button.prop('disabled', true);
                    button.html(d.paginator.links[row].label);
                    pagination.append(li.append(button));
                }

                var elements = document.getElementsByClassName("page-link btn-sm");
                for (var i = 0; i < elements.length; i++) {
                    elements[i].addEventListener('click', paginationFunc, false);
                }
            }

            $('#search').on('keyup', function() {
                var s = $(this).val();
                getData("{{route('applicants.data')}}?search="+s).then(result => { makeStruct(result); });
            });
        });
    </script>

@stop
