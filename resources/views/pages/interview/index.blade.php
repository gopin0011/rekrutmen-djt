@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><small><i class="fa fa-comments"></i></small> <strong>Interview</strong></h5>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-xl" id="ajaxModal" arial-hidden="true">
        <input type="hidden" name="type" id="type" value="">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                </div>
                <div class="modal-body">
                    <table id="table" class="table table-striped data-table display nowrap" width="100%">
                        <thead>
                            <tr>
                                <td colspan="9">
                                    <input type="text" placeholder="Nama atau Email Staff" class="form-control" id="search" aria-label="search" aria-describedby="basic-addon1">
                                </td>
                            </tr>
                            <tr>
                                <th width="50px">#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Aksi</th>
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
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <form method="POST" action="{{ route('interviews.store',['id'=>$id]) }}">
        @csrf
        <div class="card">
            <div class="card-body"><input id="data_id" name="data_id" value="{{ $data->id ?? '' }}" hidden>
                <input type="hidden" name="application_id" id="application_id" value="{{ $id }}">

                <div {{ (Auth::user()->admin == 6 ? 'hidden="hidden"' : Auth::user()->admin == 7) ? 'hidden="hidden"' : ''}}>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="nama_hr" value="{{ $data->namahr ?? '' }}" id="nama_hr" name="nama_hr"
                                aria-describedby="basic-addon1" placeholder="Nama HR">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <textarea rows="5" class="form-control" aria-label="interview_hr" id="interview_hr" name="interview_hr"
                                aria-describedby="basic-addon1" placeholder="Hasil interview dengan HR">{{ $data->inthr ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div {{ Auth::user()->admin == 7 ? 'hidden="hidden"' : ''}}>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="nama_user" value="{{ $data->namauser ?? '' }}" id="nama_user" name="nama_user"
                                aria-describedby="basic-addon1" placeholder="Nama user">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <textarea rows="5" class="form-control" aria-label="interview_user" id="interview_user" name="interview_user"
                                aria-describedby="basic-addon1" placeholder="Hasil interview dengan user">{{ $data->intuser ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <a data-toggle="tooltip" type="button" href="javascript:void(0)" id="share" class="edit btn btn-primary btn-sm"><i class="fa fa-share-alt"></i></a>
                            &nbsp;*) Bagikan dengan user agar user mengisi hasil interview
                        </div>
                    </div>
                </div>

                <div {{ Auth::user()->admin == 6 ? 'hidden="hidden"' : ''}}>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="nama_manajemen" value="{{ $data->namamana ?? '' }}" id="nama_manajemen" name="nama_manajemen"
                                aria-describedby="basic-addon1" placeholder="Nama manajemen">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <textarea rows="5" class="form-control" aria-label="interview_manajemen" id="intmana" name="interview_manajemen"
                                aria-describedby="basic-addon1" placeholder="Hasil interview dengan manajemen">{{ $data->intmana ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <a data-toggle="tooltip" type="button" href="javascript:void(0)" id="sharemana" class="edit btn btn-primary btn-sm"><i class="fa fa-share-alt"></i></a>
                            &nbsp;*) Bagikan dengan manajemen agar manajemen mengisi hasil interview
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group mb-3 col-md-12">
                        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- @include('sweetalert::alert') --}}
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
    <script type="text/javascript">
        $(function() {
            $("#share").click(function() {
                $('#table').find('tbody').empty();
                $("#dataForm").trigger("reset");
                $("#modalHeading").html("Pilih User dari data Staff");
                $("#type").val("user");
                $("#ajaxModal").modal('show');
            });

            $("#sharemana").click(function() {
                $('#table').find('tbody').empty();
                $("#dataForm").trigger("reset");
                $("#modalHeading").html("Pilih Manajement dari data Staff");
                $("#type").val("mana");
                $("#ajaxModal").modal('show');
            });

            const getData = async (url) => {
                const request = await fetch(url);
                const d = await request.json();

                return d;
            };

            var paginationFunc = function()
            {
                var d = JSON.parse(this.getAttribute("data-attribute"));

                getData(d).then(result => { makeStruct(result); });

                return false;
            };

            function ValidateEmail(input) {
                var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                if (input.match(validRegex)) {
                    return true;
                } 
                return false;
            }

            function funcShare()
            {
                var user_id = $(this).data("id");
                var email = $(this).data("email");
                var type = $("#type").val();

                if(email == '') return alert('Email user ini masih kosong, silahkan edit staff terlebih dahulu.');

                if(confirm("Aksi ini tidak bisa dibatalkan, lanjut untuk kirim email ke "+email+"?")) {
                    const send = async (act) => {
                        const request = await fetch(act);
                        const d = await request.json();
                        return d;
                    };

                    var action = "{{route('interviews.share.test', [':id',':userId',':type'])}}".replace(':id', "{{$id}}").replace(':userId', user_id).replace(':type', 'type='+type);
                    send(action).then(result => { console.log(result); alert('Tautan Telah dikirimkan ke email user'); }).catch(e => console.log(e));
                }
            }

            function makeStruct(d)
            {
                // add to table
                $('#table').find('tbody').empty();

                if(Object.keys(d.paginator.data).length > 0)
                {
                    for (const row of Object.keys(d.paginator.data))
                    {
                        var data = d.paginator.data[row];

                        $('#table').find('tbody').append("<tr><td class='text-center'>"+(parseInt(data.id))+"</td><td>"+data.name+"</td><td>"+data.email+"</td><td id='td"+row+"'></td></tr>");
                        if(ValidateEmail(data.email)) {
                            var $tautan = $('<a>', { 'href':'javascript:void(0);', 'type':'button', 'data-toggle':'tooltip', 'data-id': data.id, 'data-email': data.email, 'data-original-title':'Edit', 'class': 'edit btn btn-primary btn-sm share' });
                            $tautan.text('Kirim Tautan Ke Email User');
                        } else {
                            var $tautan = $('<a>', { 'href':'javascript:void(0);', 'data-toggle':'tooltip', 'data-original-title':'Not Valid', 'class': 'text-danger' });
                            $tautan.text('Edit Data Email Staff Terlebih Dahulu');
                        }

                        $('<div>', { class: 'btn-group' }).append($tautan).appendTo($('#td'+row));

                    }
                }

                var elements = $('.share');
                for (var i = 0; i < elements.length; i++) { 
                    elements[i].addEventListener('click', funcShare, false);
                }
            }

            $('#search').on('keyup', function() {
                var s = $(this).val();
                getData("{{route('staff.data')}}?search="+s).then(result => { makeStruct(result); });
            });

            function sendWhatsAppMessage(phoneNumber, message) {
                const encodedMessage = encodeURIComponent(message);
                const url = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
                window.open(url, 'WhatsApp');
            }

            // Contoh penggunaan:
            const link = 'https://www.google.com';
            const message = `Halo, cek link ini: ${link}`;
            sendWhatsAppMessage('6281394420922', message);
        });
    </script>
@stop
