@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><small><i class="fa fa-comments"></i></small> <strong>Daftar Pertanyaan</strong></h5>
            </div>
        </div>
    </div>
@stop

@section('content')
@if($mustUpload)
Silahkan Unggah CV / Berkas Terlebih Dahulu
@else
    <form method="POST" action="{{ route('applicant_answers.store') }}">
        @csrf
        <div class="card">
            <div class="card-body"><input id="data_id" name="data_id" value="{{ $data->id ?? '' }}" hidden>
                <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->admin == 0 ? Auth::user()->id : $id }}">
                <div class="form-column">
                    <p>Apa alasan Anda bersedia mengikuti proses rekrutmen di PT. Dwida Jaya Tama?</p>
                    <div class="input-group mb-3 col-md-12">
                        <textarea class="form-control" name="alasan" id="alasan" required>{{ $data->alasan ?? '' }}</textarea>
                    </div>
                </div>

                <div class="form-column">
                    <p>Sebutkan bidang yang menjadi minat Anda dalam bekerja, jelaskan!</p>
                    <div class="input-group mb-3 col-md-12">
                        <textarea class="form-control" name="bidang" id="bidang" required>{{ $data->bidang ?? '' }}</textarea>
                    </div>
                </div>

                <div class="form-column">
                    <p>Apa rencana Anda dalam 3 - 5 tahun ke depan?</p>
                    <div class="input-group mb-3 col-md-12">
                        <textarea class="form-control" name="rencana" id="rencana" required>{{ $data->rencana ?? '' }}</textarea>
                    </div>
                </div>

                <div class="form-column">
                    <p>Prestasi apa saja yang pernah Anda raih?</p>
                    <div class="input-group mb-3 col-md-12">
                        <textarea class="form-control" name="prestasi" id="prestasi" required>{{ $data->prestasi ?? '' }}</textarea>
                    </div>
                </div>

                <div class="form-column">
                    <p>Apakah saat ini, Anda melamar pekerjaan di perusahaan selain PT. Dwida Jaya Tama? Jika ya, sebutkan!</p>
                    <div class="input-group mb-3 col-md-12">
                        <textarea class="form-control" name="lamaran" id="lamaran" required>{{ $data->lamaran ?? '' }}</textarea>
                    </div>
                </div>

                <div class="form-column">
                    <p>Berikan gambaran mengenai diri Anda, mencakup: kehidupan keluarga, hobi, tokoh yang menginspirasi, kondisi yang tidak sesuai dengan harapan di tempat kerja saat ini dan diharapkan di PT. Dwida Jaya Tama, dan kontribusi yang dapat diberikan kepada PT. Dwida Jaya Tama apabila bergabung.</p>
                    <div class="input-group mb-3 col-md-12">
                        <textarea class="form-control" name="deskripsi" id="deskripsi" required>{{ $data->deskripsi ?? '' }}</textarea>
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
@endif    
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
