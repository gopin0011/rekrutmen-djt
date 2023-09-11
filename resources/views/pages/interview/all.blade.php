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

    <div class="modal fade bd-example-modal-lg" id="ajaxModalShare" arial-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">Select User</h4>
                </div>
                <div class="modal-body">
                    <table id="tableUser" class="table" width="100%">
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
                                <th>Untuk User</th>
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
    <style>
        label {
            margin-bottom: 0;
        }
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 30px;
            height: 30.5px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 10px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(11px);
            -ms-transform: translateX(11px);
            transform: translateX(11px);
        }
    </style>
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
            var user = {
                'name' : null,
                'posisi': null
            };

            var application = null;

            // $(".is-lock").change(function(){
            //     let lock = '0';

            //     if ($(this).is(":checked")) {
            //         lock = '1';
            //     }
                
            //     console.log(lock);
            // });
            
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
                // "lengthMenu": [ 50 ],
                "paging": true,
                "pageLength": 10,
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
                'iDisplayLength': 10,
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
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'posisi',
                        name: 'posisi',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'lahir',
                        name: 'lahir',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'usia',
                        name: 'usia',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'kontak',
                        name: 'kontak',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'user.email',
                        name: 'email',
                        searchable: false,
                        orderable: false,
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

            function sendWhatsAppMessage(phoneNumber, message) {
                const encodedMessage = encodeURIComponent(message);
                const url = `https://api.whatsapp.com/send/?phone=${phoneNumber}&text=${encodedMessage}`;
                window.open(url, 'WhatsApp');
            }

            function funcShare()
            {
                var kontak = $(this).data("kontak");
                var id = $(this).data("id");
                var staff = $(this).data("staff");
                var name = $(this).data("username");
                var posisi = $(this).data("posisi");

                var checkUser = $('#forUser'+staff).is(":checked");

                if(kontak == '') return alert('Kontak user ini masih kosong, silahkan edit staff terlebih dahulu.');

                if(confirm("Aksi ini tidak bisa dibatalkan, lanjut untuk kirim Whatsapp ke "+kontak+"?")) {
                    var link =  "{{route('applications.printAll', [':id'])}}".replace(':id', id);
                   
                    link += "?all=1&share=1&staff="+staff;
                    if(checkUser == true) {
                        link += "&forUser=1";
                    }
                    else {
                        link += "&forUser=0";
                    }

                    const message = `Kepada Yth. Bapak/Ibu Pimpinan Departemen, berikut kandidat atas nama ${user.name} untuk Posisi ${posisi} PT Dwida Jaya Tama: ${link}`;
                    var phoneNumber = replacePhonePrefix(kontak);
                    sendWhatsAppMessage(phoneNumber, message);
                }
            }

            const getData = async (url) => {
                const request = await fetch(url);
                const d = await request.json();

                return d;
            };

            function makeStruct(d)
            {
                // add to table
                $('#tableUser').find('tbody').empty();

                if(Object.keys(d.paginator.data).length > 0)
                {
                    for (const row of Object.keys(d.paginator.data))
                    {
                        var data = d.paginator.data[row];

                        $('#tableUser').find('tbody').append("<tr><td class='text-center'>"+(parseInt(data.id))+"</td><td>"+data.name+"</td><td>"+data.kontak+"</td><td><input type='checkbox' name='forUser[]' id='forUser"+data.id+"'></td><td id='td"+row+"'></td></tr>");
                        if(validatePhone(data.kontak)) {
                            var $tautan = $('<a>', { 'href':'javascript:void(0);', 'type':'button', 'data-toggle':'tooltip', 'data-id': application, 'data-staff': data.id, 'data-kontak': data.kontak, 'data-username': user.name, 'data-posisi': user.posisi, 'data-original-title':'Edit', 'class': 'edit btn btn-success btn-sm share' });
                            $tautan.text('Whatsapp');
                        } else {
                            var $tautan = $('<a>', { 'href':'javascript:void(0);', 'data-toggle':'tooltip', 'data-original-title':'Not Valid', 'class': 'text-danger' });
                            $tautan.text(' ');
                        }

                        $('<div>', { class: 'btn-group' }).append($tautan).appendTo($('#td'+row));

                    }
                }

                var elements = $('.share');
                for (var i = 0; i < elements.length; i++) { 
                    elements[i].addEventListener('click', funcShare, false);
                }
            }

            $('body').on('click', '.shareData', function() {
                $('#tableUser').find('tbody').empty();
                var data_id = $(this).data("id");
                application = data_id;
                user.name = $(this).data("username");
                user.posisi = $(this).data("posisi");

                $("#ajaxModalShare").modal('show');
            });

            $('#search').on('keyup', function() {
                var s = $(this).val();
                getData("{{route('staff.data')}}?search="+s).then(result => { makeStruct(result); });
            });

            // function editLock()
            // {
            //     var data_id = $(this).data("id");
            //     console.log(data_id);
            // }

            // var elements = $('.is-lock'); //document.getElementsByClassName("profile");
            // for (var i = 0; i < elements.length; i++) { 
            //     // elements[i].addEventListener('change', editLock, false);
            //     console.log(elements[i]);
            // }

        });

        $(document).ready(function() {
            $('.data-table').on('change', '.is-lock', function() {
                let lock = 0;
                let id = $(this).data('id');
                if ($(this).is(":checked")) {
                    lock = 1;
                }
                
                const url = "{{ route('applications.lock') }}";
                const data = {
                    id: id,
                    lock: lock
                };

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        "X-CSRF-TOKEN": '{{ csrf_token() }}',
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Response:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });

    </script>

@stop
