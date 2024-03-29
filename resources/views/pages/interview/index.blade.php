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
                                    <input type="text" placeholder="Nama, email atau kontak staff" class="form-control" id="search" aria-label="search" aria-describedby="basic-addon1">
                                </td>
                            </tr>
                            <tr>
                                <th width="50px">#</th>
                                <th>Nama</th>
                                <th>Kontak</th>
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
                    <div class="form-group-label">
                        <label class="form-label">HR</label>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-12">
                                <!-- <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-user"></i></span>
                                </div> -->
                                <input type="text" class="form-control" aria-label="nama_hr" value="{{ $data->namahr ?? '' }}" id="nama_hr" name="nama_hr"
                                    aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-12">
                                <textarea rows="5" class="form-control" aria-label="interview_hr" id="interview_hr" name="interview_hr"
                                    aria-describedby="basic-addon1" placeholder="Hasil interview dengan HR">{{ $data->inthr ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div {{ Auth::user()->admin == 7 ? 'hidden="hidden"' : ''}}>
                    <div class="form-group-label">
                        <label class="form-label">USER</label>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-12">
                                <!-- <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-user"></i></span>
                                </div> -->
                                    <input type="text" class="typeahead form-control" name="nama_user" id="nama_user" value="{{ $data->namauser ?? '' }}" />
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
                </div>

                <div {{ Auth::user()->admin == 6 ? 'hidden="hidden"' : ''}}>
                    <div class="form-group-label">
                        <label class="form-label">MANAGEMENT</label>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-12">
                                <!-- <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-user"></i></span>
                                </div> -->
                                <input type="text" class="typeahead form-control" value="{{ $data->namamana ?? 'Ary Widyarso' }}" id="nama_manajemen" name="nama_manajemen" />
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />
        
    <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
    <link rel="stylesheet" type="text/css" href="{{asset('bootstrap-tagsinput/bootstrap-tagsinput.css')}}" />
    <link rel="stylesheet" type="text/css" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/assets/app.css" />
    <!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"> -->
    
    <style>
        .label-info {
            background-color: #5bc0de;
        }
        .label {
            display: inline;
            padding: 0.2em 0.6em 0.3em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25em;
        }
        
        .bootstrap-tagsinput {
            width: 100%;
        }
        .bs-example {
            width: 100%;
        }

        .form-group-label{
            padding:10px;
            border:1px solid #c0c0c0;
            margin:10px 0;
        }
        .form-group-label > label{
            /* position:absolute; */
            top:-1px;
            left:20px;
            background-color:white;
            padding: 0px 10px;
        }

        .form-group-label > input{
            border:none;
        }
    </style>
@stop

@section('js')
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script> -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="{{asset('bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/assets/app.js"></script>
    <script type="text/javascript">
        $(function() {
            $(document).on('keypress',function(e) {
                if(e.which == 13) {
                    e.preventDefault();
                    // alert('You pressed enter!');
                }
            });

            var user = {!! json_encode($user) !!};
            var posisi = '{!!$posisi!!}';

            let teams = [];


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

            function validatePhone(phone) {
                // Format nomor telepon yang diizinkan adalah 0xx-xxxxxxx atau 0xxx-xxxxxxx
                const phoneRegex = /^(0\d{2,3})-?\d{7,8}$/;
                return phoneRegex.test(phone);
            }

            function replacePhonePrefix(phone) {
            // Cek apakah nomor telepon diawali dengan "0"
                if (phone.startsWith('0')) {
                    // Ganti "0" dengan "62"
                    return phone.replace(/^0/, '62');
                }
                // Jika tidak, kembalikan nomor telepon yang sama
                return phone;
            }

            function funcShareWa()
            {
                var user_id = $(this).data("id");
                var kontak = $(this).data("kontak");
                var type = $("#type").val();

                if(kontak == '') return alert('Kontak user ini masih kosong, silahkan edit staff terlebih dahulu.');

                if(confirm("Aksi ini tidak bisa dibatalkan, lanjut untuk kirim Whatsapp ke "+kontak+"?")) {
                    const link = "{{route('interviews.share.test', [':id',':userId',':type', 'whatsapp' => '1'])}}".replace(':id', "{{$id}}").replace(':userId', user_id).replace(':type', type);
                    const message = `Kepada Yth. Bapak/Ibu Pimpinan Departemen, berikut isian hasil interview kandidat atas nama ${user.name} untuk Posisi ${posisi}: ${link}`;
                    var phoneNumber = replacePhonePrefix(kontak);
                    sendWhatsAppMessage(phoneNumber, message);
                }
            }

        var result = getData("{{route('staff.data')}}?to_json=1&search=").then(r => { 
            let arrayLength = r.length;
            for (let i = 0; i < arrayLength; i++) {
                if (!teams.includes(r[i])) {
                    teams.push(r[i]);
                }
            }
         });

         
        // var citynames = new Bloodhound({
        //     datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        //     queryTokenizer: Bloodhound.tokenizers.whitespace,
        //     prefetch: {
        //         url: "{{asset('hr.json')}}",
        //         filter: function(list) {
        //         return $.map(list, function(cityname) {
        //             return { name: cityname }; });
        //         }
        //     }
        // });

        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
                var matches, substringRegex;

                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');

                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, str) {
                    if (substrRegex.test(str.name)) {
                        matches.push(str.name);
                    }
                });
                
                cb(matches);
            };
        };

        $('#nama_user, #nama_hr').tagsinput({
            typeaheadjs: {
                name: 'citynames',
                // displayKey: 'name',
                // valueKey: 'name',
                source: substringMatcher(teams)
            }
        });
        
        $('#nama_manajemen').tagsinput();

        // $('#nama_user').typeahead({
        //     hint: true,
        //     highlight: true,
        //     minLength: 1
        // },
        // {
        //     name: 'states',
        //     source: substringMatcher(teams)
        // });

        // citynames.initialize();

        // $('#nama_user').tagsinput({
        //     typeaheadjs: {
        //         name: 'citynames',
        //         displayKey: 'name',
        //         valueKey: 'name',
        //         source: citynames.ttAdapter()
        //     }
        // });

            function makeStruct(d)
            {
                // add to table
                $('#table').find('tbody').empty();

                if(Object.keys(d.paginator.data).length > 0)
                {
                    for (const row of Object.keys(d.paginator.data))
                    {
                        var data = d.paginator.data[row];

                        $('#table').find('tbody').append("<tr><td class='text-center'>"+(parseInt(data.id))+"</td><td>"+data.name+"</td><td id='td-wa"+row+"'></td><td>"+data.email+"</td><td id='td"+row+"'></td></tr>");
                        if(ValidateEmail(data.email)) {
                            var $tautan = $('<a>', { 'href':'javascript:void(0);', 'type':'button', 'data-toggle':'tooltip', 'data-id': data.id, 'data-email': data.email, 'data-original-title':'Edit', 'class': 'edit btn btn-primary btn-sm share' });
                            $tautan.text('Kirim Tautan Ke Email User');
                        } else {
                            var $tautan = $('<a>', { 'href':'javascript:void(0);', 'data-toggle':'tooltip', 'data-original-title':'Not Valid', 'class': 'text-danger' });
                            $tautan.text('Edit Data Email Staff Terlebih Dahulu');
                        }

                        if(validatePhone(data.kontak)) {
                            var $tautan2 = $('<a>', { 'href':'javascript:void(0);', 'type':'button', 'data-toggle':'tooltip', 'data-id': data.id, 'data-kontak': data.kontak, 'data-original-title':'Edit', 'class': 'edit btn btn-success btn-sm share-wa' });
                            $tautan2.text(data.kontak);
                        } else {
                            var $tautan2 = $('<a>', { 'href':'javascript:void(0);', 'data-toggle':'tooltip', 'data-original-title':'Not Valid', 'class': 'text-danger' });
                            $tautan2.text('');
                        }

                        $('<div>', { class: 'btn-group' }).append($tautan).appendTo($('#td'+row));
                        $('<div>', { class: 'btn-group' }).append($tautan2).appendTo($('#td-wa'+row));

                    }
                }

                var elements = $('.share');
                for (var i = 0; i < elements.length; i++) { 
                    elements[i].addEventListener('click', funcShare, false);
                }

                var elements2 = $('.share-wa');
                for (var i = 0; i < elements2.length; i++) { 
                    elements2[i].addEventListener('click', funcShareWa, false);
                }
            }

            $('#search').on('keyup', function() {
                var s = $(this).val();
                getData("{{route('staff.data')}}?search="+s).then(result => { makeStruct(result); });
            });

            function sendWhatsAppMessage(phoneNumber, message) {
                const encodedMessage = encodeURIComponent(message);
                const url = `https://api.whatsapp.com/send/?phone=${phoneNumber}&text=${encodedMessage}`;
                window.open(url, 'WhatsApp');
            }

            // Contoh penggunaan:
            const link = 'https://www.google.com';
            const message = `Halo, cek link ini: ${link}`;
            // sendWhatsAppMessage('6281394420922', message);
        });
    </script>
@stop
