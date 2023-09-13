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
    <div class="row">
        <form>
                <h5>Hasil Interview Dengan Kandidat</h5>
        </form>
    </div>
    <div class="row">
    <form method="POST" action="{{ route('user.form.add.interview.store',['id'=>$id]) }}">
        @csrf
        <div class="card">
            <div class="card-body">
                <input id="data_id" name="data_id" value="{{ $interview->id ?? '' }}" hidden>
                <input id="type" name="type" value="{{ $data->type }}" type="hidden">
                <input type="hidden" name="application_id" id="application_id" value="{{ $id }}">

                <div>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="nama_user" value="{{ $application->user->name }}" id="nama_user" name="nama_user" aria-describedby="basic-addon1" placeholder="Nama user" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-briefcase"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="nama_user" value="{{$application->vacancy->name}}" id="nama_user" name="nama_user" aria-describedby="basic-addon1" placeholder="Nama user" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="nama_user" value="{{ $application->namauser ?? $data->staff->name }}" id="nama_user" name="nama_user"
                                aria-describedby="basic-addon1" placeholder="Nama user">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group mb-3 col-md-12">
                            <textarea rows="5" class="form-control" aria-label="interview_user" id="interview_user" name="interview_user"
                                aria-describedby="basic-addon1" placeholder="Hasil interview">{{ $application->intuser ?? '' }}</textarea>
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
    </div>
    {{-- @include('sweetalert::alert') --}}
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    
@stop

@section('js')
    
@stop
