@extends('layouts.guest')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content')
    
            <div class="row">
                <div class="col-md-12 mt-5">
                    <div class="text-center">
                    @if (\Session::has('message')) 
                    <!-- <form> -->
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Ok!</h5>
                            {{\Session::get('message')}}
                        </div>
                    <!-- </form> -->
                    @endif
                        <button type="button" class="btn btn-primary" onclick="gantiSrc('{!!$gdocs!!}');">Aplikasi</button>
                        <button type="button" class="btn btn-success" onclick="gantiSrc('{!!$formHasilInterview!!}');">Hasil Interview</button>
                    </div>
                    <iframe id="iframe" class="mt-5"></iframe>
                </div>
            </div>
    {{-- @include('sweetalert::alert') --}}
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #iframe {
            width: 100%;
            height: 100vh;
        }
    </style>
@stop

@section('js')
<script>
    function gantiSrc(url) {
            var myDiv = document.getElementById('iframe');
            iframe.src = url;

            // var xhr = new XMLHttpRequest();
            // xhr.open('GET', url, true);

            // xhr.onreadystatechange = function() {
            //     if (xhr.readyState === 4 && xhr.status === 200) {
            //     // Isi myDiv dengan konten yang dimuat dari URL
            //     myDiv.innerHTML = xhr.responseText;
            //     }
            // };

            // xhr.send();
        }
</script>        
@stop
