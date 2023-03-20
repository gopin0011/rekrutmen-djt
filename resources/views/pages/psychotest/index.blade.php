@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><small><i class="fa fa-head-side-virus"></i></small> <strong>Psikotes</strong></h5>
            </div>
        </div>
    </div>
@stop

@section('content')
    <form method="POST" action="{{ route('psychotests.store',['id'=>$id]) }}">
        @csrf
        <div class="card">
            <div class="card-body"><input id="data_id" name="data_id" value="{{ $data->id ?? '' }}" hidden>
                <input type="hidden" name="user_id" id="user_id" value="{{ $id }}">

                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-head-side-virus"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="disctest" value="{{ $data->disctest ?? '' }}" id="disctest" name="disctest"
                                aria-describedby="basic-addon1" placeholder="Nilai Disctest">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-head-side-virus"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="ist" value="{{ $data->ist ?? '' }}" id="ist" name="ist"
                                aria-describedby="basic-addon1" placeholder="Nilai IST">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-head-side-virus"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="cfit" value="{{ $data->cfit ?? '' }}" id="cfit" name="cfit"
                                aria-describedby="basic-addon1" placeholder="Nilai CFIT">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-head-side-virus"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="armyalpha" value="{{ $data->armyalpha ?? '' }}" id="armyalpha" name="armyalpha"
                                aria-describedby="basic-addon1" placeholder="Nilai Army Alpha">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-head-side-virus"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="papikostik" value="{{ $data->papikostik ?? '' }}" id="papikostik" name="papikostik"
                                aria-describedby="basic-addon1" placeholder="Nilai Papikostik">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-head-side-virus"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="kreplin" value="{{ $data->kreplin ?? '' }}" id="kreplin" name="kreplin"
                                aria-describedby="basic-addon1" placeholder="Nilai Kreplin">
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
