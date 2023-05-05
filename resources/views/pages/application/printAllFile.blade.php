@extends('layouts.guest')

@section('title', 'HR | PT. Dwida Jaya Tama')
@section('content')
<div class="modal fade bd-example-modal-xl" id="ajaxModal" arial-hidden="true">
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
<div class="row mt-3" id="rowShare">
    <a data-toggle="tooltip" type="button" href="javascript:void(0)" id="share" class="edit btn btn-primary btn-sm">
        <i class="fa fa-share-alt"></i>
    </a>
</div>
<div class="row mt-3">
    <iframe src ="{{ asset('/laraview/#../'.$rekrutmen_pdf) }}" style="width: 100vw; height: 100vh;"></iframe>
</div>
@if($cv_url)
<div class="row">
    <iframe src ="{{ asset('/laraview/#../'.$cv_url) }}" style="width: 100vw; height: 100vh;"></iframe>
</div>
@endif

@stop

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/adminlte.min.css')}}">

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        $(function() {
            var user = {!! json_encode($user) !!};
            var posisi = '{!!$posisi!!}';
            var thisUrl = '{!!$thisUrl!!}';
            console.log(user);

            const urlParams = new URLSearchParams(window.location.search);
            var shareParam = urlParams.get('share');
            shareParam = (shareParam == '1') ? shareParam : null;

            if(shareParam == '1') {
                $('#rowShare').hide();
            }

            $("#share").click(function() {
                $('#table').find('tbody').empty();
                $("#dataForm").trigger("reset");
                $("#modalHeading").html("Pilih User dari data Staff");
                $("#ajaxModal").modal('show');
            });

            const getData = async (url) => {
                const request = await fetch(url);
                const d = await request.json();

                return d;
            };

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
                const url = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
                window.open(url, 'WhatsApp');
            }

            function funcShare()
            {
                var kontak = $(this).data("kontak");

                if(kontak == '') return alert('Kontak user ini masih kosong, silahkan edit staff terlebih dahulu.');

                if(confirm("Aksi ini tidak bisa dibatalkan, lanjut untuk kirim Whatsapp ke "+kontak+"?")) {
                    const link = thisUrl;
                    const message = `Kepada Yth. Bapak/Ibu Pimpinan Departemen, berikut kandidat atas nama ${user.name} untuk Posisi ${posisi} PT Dwida Jaya Tama: ${link}`;
                    var phoneNumber = replacePhonePrefix(kontak);
                    sendWhatsAppMessage(phoneNumber, message);
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

                        $('#table').find('tbody').append("<tr><td class='text-center'>"+(parseInt(data.id))+"</td><td>"+data.name+"</td><td>"+data.kontak+"</td><td id='td"+row+"'></td></tr>");
                        if(validatePhone(data.kontak)) {
                            var $tautan = $('<a>', { 'href':'javascript:void(0);', 'type':'button', 'data-toggle':'tooltip', 'data-id': data.id, 'data-kontak': data.kontak, 'data-original-title':'Edit', 'class': 'edit btn btn-success btn-sm share' });
                            $tautan.text('Kirim Tautan Ke Whatsapp User');
                        } else {
                            var $tautan = $('<a>', { 'href':'javascript:void(0);', 'data-toggle':'tooltip', 'data-original-title':'Not Valid', 'class': 'text-danger' });
                            $tautan.text('Edit Data Kontak Staff Terlebih Dahulu');
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


        });
    </script>
@stop