@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><i class="fa fa-list"></i> <strong>Overtimes</strong></h5>
            </div>
        </div>
    </div>
@stop
@section('content')
<!-- <div class="content-wrapper">
    <section class="content" style="padding-top:15px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">    -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><strong>Detail SPL</strong></h3>
                            <form id="dataForm" method="POST" action="{{ route('overtimes.edit', ['id' => $overtime->id]) }}">
                            <input name="revisi" type="text" class="form-control" value="{{ $revisi }}" hidden="hidden">
                                <div class="input-group mb-3"> 
                                    <input name="nomor" type="text" class="form-control" value="{{ $overtime->nomor }}" hidden="hidden">
                                    <input name="bisnis" type="text" class="form-control" value="{{ $overtime->bisnis }}" hidden="hidden">
                                    <input name="divisi" type="text" class="form-control" value="{{ $overtime->divisi }}" hidden="hidden">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-calendar" style="width: 15px"></span>
                                        </div>
                                    </div>
                                    <select class="form-control" id="waktu" name="waktu">
                                        <option value='Hari Kerja' {{ $overtime->waktu == 'Hari Kerja' ? 'selected="selected"' : '' }}>Hari Kerja</option>
                                        <option value='Hari Libur' {{ $overtime->waktu == 'Hari Libur' ? 'selected="selected"' : '' }}>Hari Libur</option>
                                    </select>    
                                    <select class="form-control" id="shift" name="shift">
                                        <option value="Shift 1" {{ $overtime->shift == 'Shift 1' ? 'selected="selected"' : '' }}>Shift 1</option>
                                        <option value="Long Shift 2" {{ $overtime->shift == 'Long Shift 2' ? 'selected="selected"' : '' }}>Long Shift 2</option>
                                        <option value="Non Shift" {{ $overtime->shift == 'Non Shift' ? 'selected="selected"' : '' }}>Non Shift</option>
                                    </select>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar-day"></i></span>
                                    </div>
                                    <input type="date" class="form-control" aria-label="date" id="date" name="date" value="{{$overtime->tanggalspl}}"
                                        aria-describedby="basic-addon1">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-edit" style="width: 15px"></span>
                                        </div>
                                    </div>
                                    <textarea name="catatan" placeholder="Catatan" type="text" class="form-control">{{ $overtime->catatan }}</textarea>
                                </div>
                                
                                @if(Auth::user()->admin ==2 || Auth::user()->admin ==3 ||Auth::user()->admin ==4 ||Auth::user()->admin ==10)
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-check" style="width: 15px"></span>
                                        </div>
                                    </div>
                                    @if(Auth::user()->admin != 4)
                                        <input type="text" class="form-control" value="Telah di approve manajer" readonly="readonly">
                                        <select class="form-control" name="manajer" hidden>
                                            <option value='' {{ $overtime->manajer == '' ? 'selected="selected"' : '' }}>Acc. Manajer</option>
                                            <option value='ditolak' {{ $overtime->manajer == 'ditolak' ? 'selected="selected"' : '' }}>Ditolak</option>
                                            <option value='diterima' {{ $overtime->manajer == 'diterima' ? 'selected="selected"' : '' }}>Diterima</option>
                                        </select>
                                    @else
                                    <select class="form-control" name="manajer">
                                        <option value='' {{ $overtime->manajer == '' ? 'selected="selected"' : '' }}>Acc. Manajer</option>
                                        <option value='ditolak' {{ $overtime->manajer == 'ditolak' ? 'selected="selected"' : '' }}>Ditolak</option>
                                        <option value='diterima' {{ $overtime->manajer == 'diterima' ? 'selected="selected"' : '' }}>Diterima</option>
                                    </select>
                                    @endif
                                    @if(Auth::user()->admin ==2 || Auth::user()->admin ==3)
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-check" style="width: 15px"></span>
                                        </div>
                                    </div>                                 
                                    <select class="form-control" name="hr" >
                                        <option value='' {{ $overtime->hr == '' ? 'selected="selected"' : '' }}>Acc. HR</option>
                                        <option value='ditolak' {{ $overtime->hr == 'ditolak' ? 'selected="selected"' : '' }}>Ditolak</option>
                                        <option value='diterima' {{ $overtime->hr == 'diterima' ? 'selected="selected"' : '' }}>Diterima</option>
                                        <option value='revisi' {{ $overtime->hr == 'revisi' ? 'selected="selected"' : '' }}>Revisi</option>
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-check" style="width: 15px"></span>
                                        </div>
                                    </div>
                                    <select class="form-control" name="status">
                                        <option value='' {{ $overtime->status == '' ? 'selected="selected"' : '' }}>Status SPL</option>
                                        <option value='ditolak' {{ $overtime->status == 'ditolak' ? 'selected="selected"' : '' }}>Ditolak</option>
                                        <option value='diterima' {{ $overtime->status == 'diterima' ? 'selected="selected"' : '' }}>Diterima</option>
                                    </select>
                                    @endif
                                </div>
                                @endif

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span style="width: 15px">A</span>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $overtime->pemohon }}" readonly="readonly">
                                    @if((Auth::user()->admin == '4')||(Auth::user()->admin == '10'))
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <span style="width: 15px">H</span>
                                            </div>
                                        </div>
                                        <input name="nmhr" type="text" class="form-control" value="{{ $overtime->nmhr }}" readonly="readonly">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <span style="width: 15px">M</span>
                                            </div>
                                        </div>
                                        <input name="nmmanajer" type="text" class="form-control" value="@if($overtime->nmmanajer == ''){{ Auth::user()->name }} @else {{ $overtime->nmmanajer }} @endif"  readonly="readonly">                            
                                    @elseif(Auth::user()->admin == '2' || Auth::user()->admin == '3')
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <span style="width: 15px">H</span>
                                            </div>
                                        </div>
                                        <input name="nmhr" type="text" class="form-control" value="@if($overtime->nmhr == ''){{ Auth::user()->name }} @else {{ $overtime->nmhr }} @endif" readonly="readonly">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <span style="width: 15px">M</span>
                                            </div>
                                        </div>
                                        @if($overtime->divisi != 'Human Resources')
                                        <input name="nmmanajer" type="text" class="form-control" value="{{ $overtime->nmmanajer }}" readonly="readonly">
                                        @else
                                        <input name="nmmanajer" type="text" class="form-control" value="@if($overtime->nmmanajer == ''){{ Auth::user()->name }} @else {{ $overtime->nmmanajer }} @endif" readonly="readonly">
                                        @endif
                                    @endif
                                </div>
    
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('overtimes.insert', ['id' => $idovertime]) }}">
                        @csrf    
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><strong>Daftar SPL</strong></h3>
                            </div>
                                <input name="nomor" type="text" class="form-control" value="{{ $overtime->nomor }}" hidden="hidden">
                                <input type="text" class="form-control" value="{{ $overtime->bisnis }}/{{ $overtime->divisi }}" hidden="hidden">

                            <div class="card-body"> 
                                <div class="card">
                                    <table id="example4" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th rowspan="2">NIK</th>
                                        <th rowspan="2">Nama</th>
                                        <th rowspan="2">Jabatan</th>
                                        <th rowspan="2">Uraian Pekerjaan</th>
                                        <th rowspan="2">SPK</th>
                                        <th rowspan="2">No. SPK</th>
                                        <th colspan="2">{{$tglSplSebelumnya['2hari']}}</th>
                                        <th colspan="2">{{$tglSplSebelumnya['1hari']}}</th>
                                        <!-- <th>Hasil</th>
                                        <th style="width: 50px">%</th> -->
                                        <th rowspan="2">Mulai</th>
                                        <th rowspan="2">Akhir</th>
                                        <th rowspan="2">Total</th>
                                        <th rowspan="2">Makan</th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th>Hasil</th>
                                        <th>Persen</th>
                                        <th>Hasil</th>
                                        <th>Persen</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $tempPekerjaan = '';
                                            $tempSpk = '';
                                            $tempNoSpk = '';
                                            $tempHasil2 = '';
                                            $tempPersen2 = '';
                                            $tempHasil = '';
                                            $tempPersen = '';
                                            $tempMulai = '';
                                            $tempAkhir = '';
                                        @endphp
                                        @foreach ($data as $item)
                                        @php 
                                            $tempPekerjaan = $item->pekerjaan;
                                            $tempSpk = $item->spk;
                                            $tempNoSpk = $item->nospk;
                                            $tempHasil2 = $item->hasil2;
                                            $tempPersen2 = $item->persen2;
                                            $tempHasil = $item->hasil;
                                            $tempPersen = $item->persen;
                                            $tempMulai = $item->mulai;
                                            $tempAkhir = $item->akhir;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->nik }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->jabatan }}</td>
                                            <td>{{ $item->pekerjaan }}</td>
                                            <td>{{ $item->spk }}</td>
                                            <td>{{ $item->nospk }}</td>
                                            <td>{{ $item->hasil2 }}</td>
                                            <td>{{ $item->persen2 }}</td>
                                            <td>{{ $item->hasil }}</td>
                                            <td>{{ $item->persen }}</td>
                                            <td>{{ $item->mulai }}</td>
                                            <td>{{ $item->akhir }}</td>
                                            <td>{{ intdiv(($item->total),60) .'.'. ($item->total)%60 }}</td>
                                            <td>{{ $item->makan }}</td>
                                            <td style="text-align:center">
                                                <a href="{{ route('overtimes.deletedetail', ['id' => $item->id]) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus">
                                                    <span class="fas fa-trash"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">
                                                <select class="form-control" id="nik" name="nik">
                                                    @foreach($employee as $item)
                                                        <option value="{{ $item->nik }}" data-jabatan="{{ $item->position }}">{{ $item->nik }} - {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input name="pekerjaan" placeholder="Pekerjaan" type="text" class="form-control" oninput="setCustomValidity('')" value="{{$tempPekerjaan}}"></td>
                                            <td><input name="spk" placeholder="SPK" type="text" class="form-control" oninput="setCustomValidity('')" value="{{$tempSpk}}"></td>
                                            <td><input name="nospk" placeholder="Nomor SPK" type="text" class="form-control" oninput="setCustomValidity('')" value="{{$tempNoSpk}}"></td>
                                            <td><input name="hasil2" placeholder="Target Hasil" type="text" class="form-control" oninput="setCustomValidity('')" value="{{$tempHasil2}}"></td>
                                            <td><input name="persen2" placeholder="Persentasi Tercapai" type="text" class="form-control" oninput="setCustomValidity('')" value="{{$tempPersen2}}"></td>
                                            <td><input name="hasil" placeholder="Target Hasil" type="text" class="form-control" oninput="setCustomValidity('')" value="{{$tempHasil}}"></td>
                                            <td><input name="persen" placeholder="Persentasi Tercapai" type="text" class="form-control" oninput="setCustomValidity('')" value="{{$tempPersen}}"></td>
                                            <td><input type="time" class="form-control" aria-label="mulai" id="mulai" name="mulai" value="{{$tempMulai}}" 
                                    aria-describedby="basic-addon1"></td>
                                            <td><input type="time" class="form-control" aria-label="akhir" id="akhir" name="akhir" value="{{$tempAkhir}}" 
                                    aria-describedby="basic-addon1"></td>
                                            <td colspan="2">
                                                <select name="makan" class="form-control menu-makan">
                                                    <optgroup label="Padang">
                                                        <option value="Padang-Rendang">Rendang</option>
                                                        <option value="Padang-Ayam Bakar">Ayam Bakar</option>
                                                        <option value="Padang-Ikan">Ikan</option>
                                                        <option value="Padang-Telur">Telur</option>
                                                    </optgroup>
                                                    <optgroup label="Pecel">
                                                        <option value="Pecel-Ayam">Ayam</option>
                                                        <option value="Pecel-Lele">Lele</option>
                                                        <option value="Pecel-Ayam Bakar">Ayam Bakar</option>
                                                    </optgroup>
                                                    <option value="Mie Goreng">Mie Goreng</option>
                                                    <option value="Nasi Goreng">Nasi Goreng</option>
                                                    <option value="Kwetiau">Kwetiau</option>
                                                    <option value="Ayam Geprek">Ayam Geprek</option>
                                                </select>
                                            </td>
                                            
                                            <td style="text-align: center">
                                                <button class="btn btn-primary btn-sm" style="color:white" data-toggle="tooltip" title="Simpan">
                                                    <span class="fas fa-save"></span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
<!--                    
                </div>
            </div>
        </div>
    </section>
</div> -->
@endsection

@section('js')
<script>
        $(document).ready(function() {
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

            $('#dataForm').submit(function(event) {
                event.preventDefault();
                
                const url = $(this).attr('action');
                const data = $(this).serializeArray();

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
                    // console.log('Response:', data);
                    if(!data.status) {
                        return alert(data.reason);
                    }

                    if(data.data.type == "admin") {
                        const message = `Kepada Yth. Bapak/Ibu Pimpinan Departemen ${data.data.atasan.name}, admin telah membuat SPL. Jika ingin approve, klik link berikut: ${data.data.link}`;

                        if(data.data.atasan.kontak == null || data.data.atasan.kontak == '') {
                            return alert("Nomor whatsapp atasan masih kosong\nHub Div Multimedia");
                        }

                        var phoneNumber = replacePhonePrefix(data.data.atasan.kontak);

                        sendWhatsAppMessage(phoneNumber, message);

                        // window.location.href = "{{route('overtimes.index')}}";

                        alert('SPL Telah di buat');
                    }
                    else {
                        if(data.data.revision) {
                            const message = `Kepada Admin Departemen ${data.data.admin.divisi.nama}, ${data.data.admin.name}.\n\n HR meminta untuk merevisi SPL Anda: ${data.data.nomor}`;

                            if(data.data.admin.kontak == null || data.data.admin.kontak == '') {
                                return alert("Nomor whatsapp admin masih kosong\nHub Div Multimedia");
                            }

                            var phoneNumber = replacePhonePrefix(data.data.admin.kontak);

                            sendWhatsAppMessage(phoneNumber, message);

                            return alert('SPL Telah di update');
                        }
                        window.location.href = "{{route('overtimes.index')}}";
                    }
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });

            const urlParams = new URLSearchParams(window.location.search);
            const revisiParam = urlParams.get('revisi');

            // Cek apakah parameter 'revisi' ada dan nilainya 1
            if (revisiParam === '1') {
                // console.log('Parameter revisi bernilai 1');
                // Lakukan tindakan atau perubahan yang sesuai jika revisi bernilai 1
                $("#example4 tfoot").hide();
            }


        });
</script>    
@endsection