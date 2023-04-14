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
                            @foreach ($overtime as $item)  
                            <form method="POST" action="{{ route('overtimes.edit', ['id' => $item->id]) }}">
                                @csrf
                                <div class="input-group mb-3"> 
                                    <input name="nomor" type="text" class="form-control" value="{{ $item->nomor }}" hidden="hidden">
                                    <input name="bisnis" type="text" class="form-control" value="{{ $item->bisnis }}" hidden="hidden">
                                    <input name="divisi" type="text" class="form-control" value="{{ $item->divisi }}" hidden="hidden">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-calendar" style="width: 15px"></span>
                                        </div>
                                    </div>
                                    <select class="form-control" id="waktu" name="waktu">
                                        <option value='Hari Kerja' {{ $item->waktu == 'Hari Kerja' ? 'selected="selected"' : '' }}>Hari Kerja</option>
                                        <option value='Hari Libur' {{ $item->waktu == 'Hari Libur' ? 'selected="selected"' : '' }}>Hari Libur</option>
                                    </select>    
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar-day"></i></span>
                                    </div>
                                    <input type="date" class="form-control" aria-label="date" id="date" name="date" value="{{$item->tanggalspl}}"
                                        aria-describedby="basic-addon1">
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
                                            <option value='' {{ $item->manajer == '' ? 'selected="selected"' : '' }}>Acc. Manajer</option>
                                            <option value='ditolak' {{ $item->manajer == 'ditolak' ? 'selected="selected"' : '' }}>Ditolak</option>
                                            <option value='diterima' {{ $item->manajer == 'diterima' ? 'selected="selected"' : '' }}>Diterima</option>
                                        </select>
                                    @else
                                    <select class="form-control" name="manajer">
                                        <option value='' {{ $item->manajer == '' ? 'selected="selected"' : '' }}>Acc. Manajer</option>
                                        <option value='ditolak' {{ $item->manajer == 'ditolak' ? 'selected="selected"' : '' }}>Ditolak</option>
                                        <option value='diterima' {{ $item->manajer == 'diterima' ? 'selected="selected"' : '' }}>Diterima</option>
                                    </select>
                                    @endif
                                    @if(Auth::user()->admin ==2 || Auth::user()->admin ==3)
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-check" style="width: 15px"></span>
                                        </div>
                                    </div>                                 
                                    <select class="form-control" name="hr" >
                                        <option value='' {{ $item->hr == '' ? 'selected="selected"' : '' }}>Acc. HR</option>
                                        <option value='ditolak' {{ $item->hr == 'ditolak' ? 'selected="selected"' : '' }}>Ditolak</option>
                                        <option value='diterima' {{ $item->hr == 'diterima' ? 'selected="selected"' : '' }}>Diterima</option>
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-check" style="width: 15px"></span>
                                        </div>
                                    </div>
                                    <select class="form-control" name="status">
                                        <option value='' {{ $item->status == '' ? 'selected="selected"' : '' }}>Status SPL</option>
                                        <option value='ditolak' {{ $item->status == 'ditolak' ? 'selected="selected"' : '' }}>Ditolak</option>
                                        <option value='diterima' {{ $item->status == 'diterima' ? 'selected="selected"' : '' }}>Diterima</option>
                                    </select>
                                    @endif
                                </div>
                                @endif
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-edit" style="width: 15px"></span>
                                        </div>
                                    </div>
                                    <textarea name="catatan" placeholder="Catatan" type="text" class="form-control">{{ $item->catatan }}</textarea>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span style="width: 15px">A</span>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $item->pemohon }}" readonly="readonly">
                                    @if((Auth::user()->admin == '4')||(Auth::user()->admin == '10'))
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <span style="width: 15px">H</span>
                                            </div>
                                        </div>
                                        <input name="nmhr" type="text" class="form-control" value="{{ $item->nmhr }}" readonly="readonly">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <span style="width: 15px">M</span>
                                            </div>
                                        </div>
                                        <input name="nmmanajer" type="text" class="form-control" value="@if($item->nmmanajer == ''){{ Auth::user()->name }} @else {{ $item->nmmanajer }} @endif"  readonly="readonly">                            
                                    @elseif(Auth::user()->admin == '2' || Auth::user()->admin == '3')
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <span style="width: 15px">H</span>
                                            </div>
                                        </div>
                                        <input name="nmhr" type="text" class="form-control" value="@if($item->nmhr == ''){{ Auth::user()->name }} @else {{ $item->nmhr }} @endif" readonly="readonly">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <span style="width: 15px">M</span>
                                            </div>
                                        </div>
                                        @if($item->divisi != 'Human Resources')
                                        <input name="nmmanajer" type="text" class="form-control" value="{{ $item->nmmanajer }}" readonly="readonly">
                                        @else
                                        <input name="nmmanajer" type="text" class="form-control" value="@if($item->nmmanajer == ''){{ Auth::user()->name }} @else {{ $item->nmmanajer }} @endif" readonly="readonly">
                                        @endif
                                    @endif
                                </div>
    
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                                </div>
                            </form>
                        @endforeach
                        </div>
                    </div>
                    <form method="POST" action="{{ route('overtimes.insert', ['id' => $idovertime]) }}">
                        @csrf    
                             
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><strong>Daftar SPL</strong></h3>
                            </div>
                            @foreach ($overtime as $item)                                   
                                <input name="nomor" type="text" class="form-control" value="{{ $item->nomor }}" hidden="hidden">
                                <input type="text" class="form-control" value="{{ $item->bisnis }}/{{ $item->divisi }}" hidden="hidden">
                            @endforeach

                            <div class="card-body"> 
                                <div class="card">
                                    <table id="example4" class="table table-bordered table-striped table-responsive w-100 d-block">
                                    <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Uraian Pekerjaan</th>
                                        <th>SPK</th>
                                        <th>No. SPK</th>
                                        <th>Hasil</th>
                                        <th style="width: 50px">%</th>
                                        <th>Mulai</th>
                                        <th>Akhir</th>
                                        <th>Total</th>
                                        <th>Makan</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->nik }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->jabatan }}</td>
                                            <td>{{ $item->pekerjaan }}</td>
                                            <td>{{ $item->spk }}</td>
                                            <td>{{ $item->nospk }}</td>
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
                                                        <option value="{{ $item->nik }}">{{ $item->nik }} - {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input name="pekerjaan" placeholder="Pekerjaan" type="text" class="form-control" oninput="setCustomValidity('')"></td>
                                            <td><input name="spk" placeholder="SPK" type="text" class="form-control" oninput="setCustomValidity('')"></td>
                                            <td><input name="nospk" placeholder="Nomor SPK" type="text" class="form-control" oninput="setCustomValidity('')"></td>
                                            <td><input name="hasil" placeholder="Target Hasil" type="text" class="form-control" oninput="setCustomValidity('')"></td>
                                            <td><input name="persen" placeholder="Persentasi Tercapai" type="text" class="form-control" oninput="setCustomValidity('')"></td>
                                            <td><input type="time" class="form-control" aria-label="mulai" id="mulai" name="mulai"
                                    aria-describedby="basic-addon1"></td>
                                            <td><input type="time" class="form-control" aria-label="akhir" id="akhir" name="akhir"
                                    aria-describedby="basic-addon1"></td>
                                            <td colspan="2">
                                                <select name="makan" class="form-control">
                                                    <option value="Nasi Padang">Nasi Padang</option>
                                                    <option value="Ayam Bakar">Ayam Bakar</option>
                                                    <option value="Ayam Geprek">Ayam Geprek</option>
                                                    <option value="Pecel Lele">Pecel Lele</option>
                                                    <option value="Pecel Ayam">Pecel Ayam</option>
                                                    <option value="Mie Goreng">Mie Goreng</option>
                                                    <option value="Nasi Goreng">Nasi Goreng</option>
                                                    <option value="Kwetiau">Kwetiau</option>
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