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
                    <form method="POST" action="{{ route('overtimes.store') }}">
                        @csrf     
                             
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><strong>Buat SPL</strong></h3>
                            </div>
                            
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-list-ol" style="width: 15px"></span>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Nomor SPL" id="nomor" name="nomor" value="SPL{{ date(now()->format('dmYHis')) }}" readonly="readonly">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar-day"></i></span>
                                    </div>
                                    <input type="date" class="form-control" aria-label="date" id="date" name="date" value="{{date('Y-m-d')}}"
                                        aria-describedby="basic-addon1">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-tasks" style="width: 15px"></span>
                                        </div>
                                    </div>
                                    <select class="form-control" id="waktu" name="waktu">
                                        <option value="Hari Kerja">Hari Kerja</option>
                                        <option value="Hari Libur">Hari Libur</option>
                                    </select>    
                                    <input type="text" class="form-control" readonly="readonly" value="{{ Auth::user()->name }}" id="pemohon" name="pemohon">
                                    <input type="text" class="form-control" placeholder="Manager Approval" id="manajer" name="manajer" readonly="readonly" hidden="hidden">
                                    <input type="text" class="form-control" placeholder="HR Approval" id="hr" name="hr" readonly="readonly" hidden="hidden">
                                </div>

                                @if(Auth::user()->admin == 2 || Auth::user()->admin == 3)
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-th" style="width: 15px"></span>
                                        </div>
                                    </div>
                                    <select class="form-control" id="bisnis" name="bisnis">
                                        @foreach($unit as $item)
                                            <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    <select class="form-control" id="divisi" name="divisi">
                                        @foreach($divisi as $item)
                                            <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>       
                                </div>
                                @else
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-th" style="width: 15px"></span>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" readonly="readonly" value="{{ Auth::user()->bisnis }}" id="bisnis" name="bisnis">
                                    <input type="text" class="form-control" readonly="readonly" value="{{ Auth::user()->divisi }}" id="divisi" name="divisi">
                                    </select>       
                                </div>
                                @endif

                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fas fa-edit" style="width: 15px"></span>
                                        </div>
                                    </div>   
                                    <input type="text" class="form-control" placeholder="Catatan" id="catatan" name="catatan">
                                    <input type="text" class="form-control" placeholder="Status SPL" id="status" name="status" readonly="readonly" hidden="hidden">
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                <!-- </div>
            </div>
        </div>
    </section>
</div> -->
@endsection