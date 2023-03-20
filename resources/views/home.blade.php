@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    @if (Auth::user()->role != '0')
        <h6>HUMAN RESOURCES INTEGRATED SYSTEM</h6>
    @else
        <h5>Selamat datang, <b>{{ Auth::user()->name; }}</b></h5>
    @endif
@stop

@section('content')
{{-- $('body').on('click','.viewPDF', function(){
    var data_id = $(this).data("id");
    window.location.href='{{route('docs.index')}}'+'/a/'+data_id;
}); --}}

    @if (Auth::user()->role != '0')
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $countAlper }}</h3>
                        <p>Staff Alat Peraga</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building-user"></i>
                    </div>
                    <a href="javascript:void(0)" class="small-box-footer" id="showStaffAlper"><i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $countLegano }}</h3>
                        <p>Staff Legano</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building-user"></i>
                    </div>
                    <a href="javascript:void(0)" class="small-box-footer" id="showStaffLegano"><i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $countAlper + $countLegano }}</h3>
                        <p>Total Karyawan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="javascript:void(0)" class="small-box-footer" id="showAll"><i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Perbandingan Jumlah Karyawan</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="donutChart"
                            style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Perbandingan Jumlah Karyawan per Bulan</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="areaChart"
                            style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @else

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

@section('css')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/jzzs/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://adminlte.io/themes/v3/plugins/chart.js/Chart.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script>
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData        = {
        labels: [
            'Alat Peraga',
            'Legano',
        ],
        datasets: [
            {
            data: [{{ $countAlper }},{{ $countLegano }}],
            backgroundColor : ['#00a65a','#2b41ff' ],
            }
        ]
        }
        var donutOptions     = {
        maintainAspectRatio : false,
        responsive : true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
        options: donutOptions
        })

        $('body').on('click', '#showStaffAlper', function() {
            window.location.href = '{{ route('staffActive.all', ['id' => 'alper']) }}';
        });

        $('body').on('click', '#showStaffLegano', function() {
            window.location.href = '{{ route('staffActive.all', ['id' => 'legano']) }}';
        });

        $('body').on('click', '#showAll', function() {
            window.location.href = '{{ route('staffActive.all', ['id' => 'all']) }}';
        });

        var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

        var areaChartData = {
        labels  : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [
            {
            label               : 'Alat Peraga',
            backgroundColor     : 'rgba(65,215,19,1)',
            borderColor         : 'rgba(65,215,19,1)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(65,215,19,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(65,215,19,1)',
            data                : [{{ $buffAlper }}]
            },
            {
            label               : 'Legano',
            backgroundColor     : 'rgba(19, 52, 215, 1)',
            borderColor         : 'rgba(19, 52, 215, 1)',
            pointRadius         : false,
            pointColor          : 'rgba(19, 52, 215, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(19, 52, 215, 1)',
            data                : [{{ $buffLegano }}]
            },
        ]
        }

        var areaChartOptions = {
        maintainAspectRatio : true,
        responsive : true,
        legend: {
            display: true
        },
        scales: {
            xAxes: [{
            gridLines : {
                display : true,
            },
            ticks: {
                beginAtZero: true,
                steps: 10,
                stepValue: 5,
            }
            }],
            yAxes: [{
            gridLines : {
                display : true,
            },
            ticks: {
                beginAtZero: true,
                steps: 10,
                stepValue: 5,
            }
            }]
        }
        }

        // This will get the first returned node in the jQuery collection.
        new Chart(areaChartCanvas, {
        type: 'bar',
        data: areaChartData,
        options: areaChartOptions
        })
    </script>

@stop
