@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><small><i class="fa fa-user"></i></small> <strong>Profil</strong></h5>
            </div>
        </div>
    </div>
@stop

@section('content')
    <form method="POST" action="{{ route('applicant_profiles.store') }}">
        @csrf
        <div class="card">
            <div class="card-body"><input id="data_id" name="data_id" value="{{ $data->id ?? '' }}" hidden>
                <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->admin == 0 ? Auth::user()->id : $id }}">
                <div class="form-row">
                    <div class="input-group mb-3 col-md-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i
                                    class="fa fa-id-card"></i></span>
                        </div>
                        <input type="text" value="{{ $data->nik ?? '' }}" class="form-control"
                        placeholder="Masukkan NIK Anda" name="nik" id="nik" required>
                    </div>
                    <div class="input-group mb-3 col-md-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i
                                    class="fa fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" aria-label="panggilan" value="{{ $data->panggilan ?? '' }}" id="panggilan" name="panggilan"
                            aria-describedby="basic-addon1" placeholder="Panggilan" required>
                    </div>
                    <div class="input-group mb-3 col-md-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-venus-mars"></i></span>
                        </div>
                        <select type="text" class="form-control" id="gender" name="gender" value="">
                            {{-- <option value="" {{ "" == $gender ? 'selected="selected"' : ''}}>Jenis Kelamin</option> --}}
                            @foreach ($genders as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $gender ? 'selected="selected"' : ''}}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3 col-md-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-ring"></i></span>
                        </div>
                        <select type="text" class="form-control" id="darah" name="darah">
                            {{-- <option value="" {{ "" == $darah ? 'selected="selected"' : ''}}>Golongan Darah</option> --}}
                                <option value="A" {{ "A" == $darah ? 'selected="selected"' : ''}}>A</option>
                                <option value="B" {{ "B" == $darah ? 'selected="selected"' : ''}}>B</option>
                                <option value="AB" {{ "AB" == $darah ? 'selected="selected"' : ''}}>AB</option>
                                <option value="O" {{ "O" == $darah ? 'selected="selected"' : ''}}>O</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group mb-3 col-md-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i
                                    class="fa fa-location-dot"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Tempat lahir" value="{{ $data->tempatlahir ?? '' }}" aria-label="tempatlahir"
                            id="tempatlahir" name="tempatlahir" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="input-group mb-3 col-md-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i
                                    class="fa fa-calendar-day"></i></span>
                        </div>
                        <input type="date" class="form-control" aria-label="tanggallahir" value="{{ $data->tanggallahir ?? '' }}" id="tanggallahir" name="tanggallahir"
                            aria-describedby="basic-addon1" required>
                    </div>
                    <div class="input-group mb-3 col-md-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i
                                    class="fa fa-phone"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Kontak" value="{{ $data->kontak ?? '' }}" aria-label="kontak"
                            id="kontak" name="kontak" aria-describedby="basic-addon1" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group mb-3 col-md-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i
                                    class="fa fa-place-of-worship"></i></span>
                        </div>
                        <select type="text" class="form-control" id="agama" name="agama" value="">
                            @foreach ($religions as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $agama ? 'selected="selected"' : ''}}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-3 col-md-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-ring"></i></span>
                        </div>
                        <select type="text" class="form-control" id="status" name="status">
                                <option value="Lajang" {{ "Lajang" == $status ? 'selected="selected"' : ''}}>Lajang</option>
                                <option value="Menikah" {{ "Menikah" == $status ? 'selected="selected"' : ''}}>Menikah</option>
                                <option value="Janda" {{ "Janda" == $status ? 'selected="selected"' : ''}}>Janda</option>
                                <option value="Duda" {{ "Duda" == $status ? 'selected="selected"' : ''}}>Duda</option>
                        </select>
                    </div>
                    <div class="input-group mb-3 col-md-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-flag"></i></span>
                        </div>
                        <select type="text" class="form-control" id="wn" name="wn">
                                <option value="WNI" {{ "WNI" == $wn ? 'selected="selected"' : ''}}>WNI</option>
                                <option value="WNA" {{ "WNA" == $wn ? 'selected="selected"' : ''}}>WNA</option>
                        </select>
                    </div>
                    <div class="input-group mb-3 col-md-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i
                                    class="fa fa-gamepad"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Hobi" value="{{ $data->hobi ?? '' }}" aria-label="hobi"
                            id="hobi" name="hobi" aria-describedby="basic-addon1" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group mb-3 col-md-6">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i
                                    class="fa fa-home"></i></span>
                        </div>
                        <textarea class="form-control" placeholder="Alamat"
                            id="alamat" name="alamat" required>{{ $data->alamat ?? '' }}</textarea>
                    </div>
                    <div class="input-group mb-3 col-md-6">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i
                                    class="fa fa-home"></i></span>
                        </div>
                        <textarea class="form-control" placeholder="Domisili"
                        id="domisili" name="domisili" required>{{ $data->domisili ?? '' }}</textarea>
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
