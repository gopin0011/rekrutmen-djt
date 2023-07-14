@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
<form id="form" action="{{route('overtimes.form-spl')}}" method="GET">

    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><i class="fa fa-list"></i> <strong>Form SPL</strong></h5>
            </div>
            <div class="col-md-3 float-right">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar-day"></i></span>
                    </div>
                    <input type="date" class="form-control" aria-label="date" id="date" name="date" value="{{$date}}"
                        aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
    </div>
    </form>
@stop

@section('content')
@if(count($detail))
          <div class="col-md-12">
            <!-- Widget: user widget style 2 -->
            <div class="card card-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-warning">
                <!-- <div class="widget-user-image">
                  <img class="img-circle elevation-2" src="../dist/img/user7-128x128.jpg" alt="User Avatar">
                </div> -->
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">Form Pengajuan Dana</h3>
                <!-- <h5 class="widget-user-desc">Lead Developer</h5> -->
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  @foreach($detail['dept'] as $key => $row)
                  <li class="nav-item">
                    <small class="nav-link">
                      {{$key}} [{{$row['kegiatan']}}] <span class="float-right badge bg-primary">{{count($row['people'])}}</span>
                    </small>
                  </li>
                  @endforeach

                  @foreach($detail['pengajuanDana']['detail'] as $key => $row)
                  <li class="nav-item">
                    <small class="nav-link">
                      {{$row[0]}} <span class="float-right badge bg-primary">Rp. {{ number_format(str_replace('.', '', $row[1])) }}</span>
                    </small>
                  </li>
                  @endforeach

                  <li class="nav-item">
                    <!-- <a href="#" class="nav-link">
                      Tasks <span class="float-right badge bg-info">5</span>
                    </a> -->
                    @php
                    $id = ($detail['pengajuanDana']['id'] !== null ? $detail['pengajuanDana']['id'] : '0');
                    @endphp
                    <form class="form-horizontal" id="formPengajuanDana" method="post" action="{{route('overtimes.insert.pengajuanDana', ['id' => $id])}}" style="padding: 10px 15px;">
                      @csrf
                      <input type="hidden" name="tanggal" value="{{$date}}">
                        <div class="input-group input-group-sm mb-0">
                            <input class="form-control form-control-sm" placeholder="Uraian" name="keterangan">
                            <input class="form-control form-control-sm col-md-3" placeholder="Jumlah (Rp)" name="jumlah" style="margin: 0 10px;">
                            <div class="input-group-append">
                            <button type="submit" class="btn btn-success">Tambah</button>
                        </div>
                    </div>
                    </form>
                  </li>

                  <li class="nav-item">
                    <a href="{{route('overtimes.view.form-pengajuan', ['tanggalspl' => $date])}}" target="_blank" class="nav-link link-black text-sm mr-2"><i class="fas fa-print mr-1"></i> Print Form Pengajuan Dana</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('overtimes.view.form-detail', ['tanggalspl' => $date])}}" target="_self" class="nav-link link-black text-sm mr-2"><i class="fas fa-print mr-1"></i> Print Form Detail</a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
@endif          
@endsection

@section('css')
<style>
.widget-user-2 .widget-user-username {
    margin-left: 0px;
}
small.nav-link {
  font-size: 15px;
}
</style>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript">
    $(function() {
        var date = $("#date");
        date.on("input", function() {
            $("#form").submit();
        });
    });
</script>
@endsection