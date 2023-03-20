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
@stop

@section('content')
    <form method="POST" action="{{ route('interviews.store',['id'=>$id]) }}">
        @csrf
        <div class="card">
            <div class="card-body"><input id="data_id" name="data_id" value="{{ $data->id ?? '' }}" hidden>
                <input type="hidden" name="application_id" id="application_id" value="{{ $id }}">

                <div {{ (Auth::user()->role == 6 ? 'hidden="hidden"' : Auth::user()->role == 7) ? 'hidden="hidden"' : ''}}>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="nama_hr" value="{{ $data->nama_hr ?? '' }}" id="nama_hr" name="nama_hr"
                                aria-describedby="basic-addon1" placeholder="Nama HR">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <textarea rows="5" class="form-control" aria-label="interview_hr" id="interview_hr" name="interview_hr"
                                aria-describedby="basic-addon1" placeholder="Hasil interview dengan HR">{{ $data->interview_hr ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div {{ Auth::user()->role == 7 ? 'hidden="hidden"' : ''}}>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="nama_user" value="{{ $data->nama_user ?? '' }}" id="nama_user" name="nama_user"
                                aria-describedby="basic-addon1" placeholder="Nama user">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <textarea rows="5" class="form-control" aria-label="interview_user" id="interview_user" name="interview_user"
                                aria-describedby="basic-addon1" placeholder="Hasil interview dengan user">{{ $data->interview_user ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div {{ Auth::user()->role == 6 ? 'hidden="hidden"' : ''}}>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="nama_manajemen" value="{{ $data->nama_manajemen ?? '' }}" id="nama_manajemen" name="nama_manajemen"
                                aria-describedby="basic-addon1" placeholder="Nama manajemen">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <textarea rows="5" class="form-control" aria-label="interview_manajemen" id="interview_manajemen" name="interview_manajemen"
                                aria-describedby="basic-addon1" placeholder="Hasil interview dengan manajemen">{{ $data->interview_manajemen ?? '' }}</textarea>
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
@stop
