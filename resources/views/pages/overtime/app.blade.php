@extends('layouts.guest')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content')
@if (\Session::has('message')) 
    <form>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Ok!</h5>
            {{\Session::get('message')}}
        </div>
    </form>
@endif
<!-- <div class="content-wrapper">
    <section class="content" style="padding-top:15px">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">    -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title"><strong>Detail SPL</strong></h3>
                            <form id="dataForm" method="POST" action="{{ route('overtimes.app.post', ['id' => $overtime->id]) }}">
                            @csrf 
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
                                    <select class="form-control" id="waktu" name="waktu" readonly>
                                        <option value='Hari Kerja' {{ $overtime->waktu == 'Hari Kerja' ? 'selected="selected"' : '' }}>Hari Kerja</option>
                                        <option value='Hari Libur' {{ $overtime->waktu == 'Hari Libur' ? 'selected="selected"' : '' }}>Hari Libur</option>
                                    </select>    
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar-day"></i></span>
                                    </div>
                                    <input type="date" class="form-control" aria-label="date" id="date" name="date" value="{{ \Carbon\Carbon::parse($overtime->tanggalspl)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('Y-m-d') }}"
                                        aria-describedby="basic-addon1" readonly>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-edit" style="width: 15px"></span>
                                        </div>
                                    </div>
                                    <textarea name="catatan" placeholder="Catatan" type="text" class="form-control">{{ $overtime->catatan }}</textarea>
                                </div>
                                
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-check" style="width: 15px"></span>
                                        </div>
                                    </div>
                                    
                                    <select class="form-control" name="manajer">
                                        <option value='' {{ $overtime->manajer == '' ? 'selected="selected"' : '' }}>Acc. Manajer</option>
                                        <option value='ditolak' {{ $overtime->manajer == 'ditolak' ? 'selected="selected"' : '' }}>Ditolak</option>
                                        <option value='diterima' {{ $overtime->manajer == 'diterima' ? 'selected="selected"' : '' }}>Diterima</option>
                                    </select>
                                    
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span style="width: 15px">A</span>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $overtime->pemohon }}" readonly="readonly">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <span style="width: 15px">M</span>
                                            </div>
                                        </div>
                                        <input name="nmmanajer" type="text" class="form-control" value="@if($overtime->nmmanajer == ''){{ $employee->name }} @else {{ $overtime->nmmanajer }} @endif"  readonly="readonly">                            
                                </div>
    
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <form method="POST" action="{{ route('overtimes.insert', ['id' => $idovertime]) }}">
                        @csrf     -->
                             
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
                                        <!-- <th rowspan="2">Aksi</th> -->
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
                                        @foreach ($detail as $item)
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
                                            <!-- <td style="text-align:center">
                                                <a href="{{ route('overtimes.deletedetail', ['id' => $item->id]) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus">
                                                    <span class="fas fa-trash"></span>
                                                </a>
                                            </td> -->
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    
                                    </table>
                                </div>
                            </div>
                        </div>
                    <!-- </form> -->
<!--                    
                </div>
            </div>
        </div>
    </section>
</div> -->
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    
@stop