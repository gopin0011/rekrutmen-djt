@extends('adminlte::page')

@section('title', 'HR | PT. Dwida Jaya Tama')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col float-left">
                <h5><i class="fa fa-user-xmark"></i> <strong>Data Staff Resign</strong></h5>
            </div>
            <div class="row">
                <a type="button" href="javascript:void(0)" id="showAlper" class="btn btn-success float-right ml-1">Alper</a>
                <a type="button" href="javascript:void(0)" id="showLegano"
                    class="btn btn-primary float-right ml-1">Legano</a>
                <a type="button" href="javascript:void(0)" id="showLegano5"
                    class="btn btn-default float-right ml-1">Legano 5</a>
                <a type="button" href="javascript:void(0)" id="showAll"
                    class="btn btn-warning float-right ml-1">Semua</a>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-xl" id="ajaxModal" arial-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="dataForm" name="dataForm" class="form-horizontal">
                        <input type="hidden" name="data_id" id="data_id">
                        <h5>Data Pribadi</h5>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Nama lengkap" aria-label="name"
                                    id="name" name="name" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-venus-mars"></i></span>
                                </div>
                                <select type="text" class="form-control" id="gender" name="gender" value="">
                                    @foreach ($genders as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-place-of-worship"></i></span>
                                </div>
                                <select type="text" class="form-control" id="religion" name="religion" value="">
                                    @foreach ($religions as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-location-dot"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Tempat lahir" aria-label="place"
                                    id="place" name="place" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-calendar-day"></i></span>
                                </div>
                                <input type="date" class="form-control" aria-label="born" id="born" name="born"
                                    aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-birthday-cake"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Usia" aria-label="age"
                                    id="age" name="age" aria-describedby="basic-addon1" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Kel</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Kelurahan" aria-label="kelurahan"
                                    id="kelurahan" name="kelurahan" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Kec</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Kecamatan" aria-label="kecamatan"
                                    id="kecamatan" name="kecamatan" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Kota</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Kota" aria-label="kota"
                                    id="kota" name="kota" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Prov</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Propinsi" aria-label="propinsi"
                                    id="propinsi" name="propinsi" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-file"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="No. KK" aria-label="kk"
                                    id="kk" name="kk" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-address-card"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="No. KTP" aria-label="ktp"
                                    id="ktp" name="ktp" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-house"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Alamat domisili"
                                    aria-label="address" id="address" name="address" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-envelope"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Alamat email" aria-label="email"
                                    id="email" name="email" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Kontak" aria-label="kontak"
                                    id="kontak" name="kontak" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">BPJS Kes</span>
                                </div>
                                <input type="text" class="form-control" placeholder="BPJS Kesehatan" aria-label="bpjs_kes"
                                    id="bpjs_kes" name="bpjs_kes" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">BPJS Tk</span>
                                </div>
                                <input type="text" class="form-control" placeholder="BPJS TK" aria-label="bpjs_tk"
                                    id="bpjs_tk" name="bpjs_tk" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Ijazah dititipkan</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Ijazah dititipkan" aria-label="titip_ijazah"
                                    id="titip_ijazah" name="titip_ijazah" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Vaksin 1</span>
                                </div>
                                <select type="text" class="form-control" id="is_vaksin1" name="is_vaksin1" value="">
                                        <option value=""></option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Vaksin 2</span>
                                </div>
                                <select type="text" class="form-control" id="is_vaksin2" name="is_vaksin2" value="">
                                        <option value=""></option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Vaksin 3</span>
                                </div>
                                <select type="text" class="form-control" id="is_vaksin3" name="is_vaksin3" value="">
                                        <option value=""></option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Vaksin 1</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Vaksin 1" aria-label="vaksin1"
                                    id="vaksin1" name="vaksin1" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Vaksin 2</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Vaksin 2" aria-label="vaksin2"
                                    id="vaksin2" name="vaksin2" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Vaksin 3</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Vaksin 3" aria-label="vaksin3"
                                    id="vaksin3" name="vaksin3" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Vaksin 4</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Vaksin 4" aria-label="vaksin4"
                                    id="vaksin4" name="vaksin4" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Nama Vaksin</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Nama Vaksin" aria-label="vaksin_name"
                                    id="vaksin_name" name="vaksin_name" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <hr>
                        <h5>Data Pekerjaan</h5>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-id-badge"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="NIK" aria-label="nik"
                                    id="nik" name="nik" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-right-to-bracket"></i></span>
                                </div>
                                <input type="date" class="form-control" aria-label="joindate" id="joindate"
                                    name="joindate" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-2">
                                <!-- <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-id-badge"></i></span>
                                </div> -->
                                <input type="text" class="form-control" placeholder="masa Kerja" aria-label="masa_kerja"
                                    id="masa_kerja" name="masa_kerja" aria-describedby="basic-addon1" readonly>
                            </div>
                            <div class="input-group mb-3 col-md-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-square-check"></i></span>
                                </div>
                                <select type="text" class="form-control" id="status" name="status"
                                    value="">
                                    @foreach ($status as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-right-to-bracket"></i></span>
                                </div>
                                <input type="date" class="form-control" aria-label="end_contract" id="end_contract"
                                    name="end_contract" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-building"></i></span>
                                </div>
                                <select type="text" class="form-control" id="corp" name="corp"
                                    value="">
                                    @foreach ($corps as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-timeline"></i></span>
                                </div>
                                <select type="text" class="form-control" id="dept" name="dept"
                                    value="">
                                    @foreach ($depts as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-sitemap"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Jabatan" aria-label="position"
                                    id="position" name="position" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-sitemap"></i></span>
                                </div>
                                <select type="text" class="form-control" id="role" name="role"
                                    value="">
                                    <option value="0">--Role--</option>
                                    <option value="3">Admin</option>
                                    <option value="4">Atasan</option>
                                </select>
                            </div>
                            <div class="input-group mb-3  col-md-6">
                                <select type="text" class="form-control" id="opsiresign" name="opsiresign">
                                    <option value="0" selected>Masih Bekerja</option>
                                    <option value="1">Resign</option>
                                </select>
                                <input type="date" class="form-control" aria-label="resign" id="resign"
                                    name="resign" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">SP 1</span>
                                </div>
                                <input type="date" class="form-control" aria-label="sp1" id="sp1" name="sp1"
                                    aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">SP 2</span>
                                </div>
                                <input type="date" class="form-control" aria-label="sp2" id="sp2" name="sp2"
                                    aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">SP 3</span>
                                </div>
                                <input type="date" class="form-control" aria-label="sp3" id="sp3" name="sp3"
                                    aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-12">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">PIC Mesin</span>
                                </div>
                                <input type="text" class="form-control" placeholder="PIC Mesin" aria-label="pic_mesin"
                                    id="pic_mesin" name="pic_mesin" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <hr>
                        <h5>Data Pendidikan</h5>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-graduation-cap"></i></span>
                                </div>
                                <select type="text" class="form-control" id="study" name="study"
                                    value="">
                                    @foreach ($study as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-building-columns"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Program Studi"
                                    aria-label="prodi" id="prodi" name="prodi" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-school"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Sekolah" aria-label="school"
                                    id="school" name="school" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-school"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="No. Ijazah" aria-label="ijazah"
                                    id="ijazah" name="ijazah" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-medal"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Sertifikat" aria-label="certi"
                                    id="certi" name="certi" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Tanggal Ijazah</span>
                                </div>
                                <input type="date" class="form-control" aria-label="tgl_ijazah" id="tgl_ijazah" name="tgl_ijazah"
                                    aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-medal"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="NIM" aria-label="nim"
                                    id="nim" name="nim" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        
                        <hr>
                        <h5>Data Keuangan & Pajak</h5>
                        <div class="form-row">
                            <div class="input-group mb-3 col-md-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-people-group"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="PTKP" aria-label="ptkp"
                                    id="ptkp" name="ptkp" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-percent"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="NPWP" aria-label="npwp"
                                    id="npwp" name="npwp" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group mb-3 col-md-6">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-circle-dollar-to-slot"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="No. Rekening" aria-label="bill"
                                    id="bill" name="bill" aria-describedby="basic-addon1">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="btnSave" value="create">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <table class="table table-striped data-table display nowrap" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th width="60px"></th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Unit Bisnis</th>
                <th>Departemen</th>
                <th>Resign</th>
                <th>Gender</th>
                <th>Agama</th>
                <th>KTP</th>
                <th>KK</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Sertifikat</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Umur</th>
                <th>Rekening</th>
                <th>NPWP</th>
                <th>PTKP</th>
                <th>Status Karyawan</th>
                <th>Tanggal Bergabung</th>
                <th>Lama Bekerja</th>
                <th>Tingkat Pendidikan</th>
                <th>Sekolah</th>
                <th>Program Studi</th>
                <th>Ijazah</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
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
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />
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
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> --}}
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <script type="text/javascript">
        $(function() {
            function newexportaction(e, dt, button, config) {
                var self = this;
                var oldStart = dt.settings()[0]._iDisplayStart;
                dt.one('preXhr', function(e, s, data) {
                    // Just this once, load all data from the server...
                    data.start = 0;
                    data.length = 2147483647;
                    dt.one('preDraw', function(e, settings) {
                        // Call the original action function
                        if (button[0].className.indexOf('buttons-copy') >= 0) {
                            $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button,
                                config);
                        } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                            $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt,
                                    button, config) :
                                $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt,
                                    button, config);
                        } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                            $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button,
                                    config) :
                                $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button,
                                    config);
                        } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                            $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                                $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button,
                                    config) :
                                $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button,
                                    config);
                        } else if (button[0].className.indexOf('buttons-print') >= 0) {
                            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                        }
                        dt.one('preXhr', function(e, s, data) {
                            // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                            // Set the property to what it was before exporting.
                            settings._iDisplayStart = oldStart;
                            data.start = oldStart;
                        });
                        // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                        setTimeout(dt.ajax.reload, 0);
                        // Prevent rendering of the full data to the DOM
                        return false;
                    });
                });
                // Requery the server with the new one-time export settings
                dt.ajax.reload();
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $(".data-table").DataTable({
                // lengthMenu: [
                //     [10, 25, 50, -1],
                //     ['10', '25', '50', 'Show All']
                // ],
                dom: 'Bfrtip',
                // rowReorder: {
                //     selector: 'td:nth-child(2)'
                // },

                responsive: true,
                serverSide: true,
                processing: true,
                ajax: '{{ $x }}',
                buttons: [{
                    extend: 'excel',
                    text: 'Cetak ke Excel',
                    // titleAttr: 'Excel',
                    action: newexportaction
                }, ],
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0,
                }, ],
                order: [
                    [2, 'asc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'corp',
                        name: 'corp'
                    },
                    {
                        data: 'dept',
                        name: 'dept'
                    },
                    {
                        data: 'resign',
                        name: 'resign'
                    },
                    {
                        data: 'gender',
                        name: 'gender'
                    },
                    {
                        data: 'religion',
                        name: 'religion'
                    },
                    {
                        data: 'ktp',
                        name: 'ktp'
                    },
                    {
                        data: 'kk',
                        name: 'kk'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'certi',
                        name: 'certi'
                    },
                    {
                        data: 'place',
                        name: 'place'
                    },
                    {
                        data: 'born',
                        name: 'born'
                    },
                    {
                        data: 'years',
                        name: 'years'
                    },
                    {
                        data: 'bill',
                        name: 'bill'
                    },
                    {
                        data: 'npwp',
                        name: 'npwp'
                    },
                    {
                        data: 'ptkp',
                        name: 'ptkp'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'joindate',
                        name: 'joindate'
                    },
                    {
                        data: 'joinyears',
                        name: 'joinyears'
                    },
                    {
                        data: 'study',
                        name: 'study'
                    },
                    {
                        data: 'school',
                        name: 'school'
                    },
                    {
                        data: 'prodi',
                        name: 'prodi'
                    },
                    {
                        data: 'ijazah',
                        name: 'ijazah'
                    },
                ],
            });

            $("#createNewData").click(function() {
                $("#data_id").val('');
                $("#dataForm").trigger("reset");
                $("#modalHeading").html("Tambah Data");
                $("#ajaxModal").modal('show');
            });

            $("#btnSave").click(function(e) {
                e.preventDefault();
                $(this).html('Simpan');

                $.ajax({
                    type: "POST",
                    url: "{{ route('staff.store') }}",
                    data: $("#dataForm").serialize(),
                    dataType: 'json',
                    success: function(data) {
                        $("#dataForm").trigger("reset");
                        $("#ajaxModal").modal('hide');
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error', data);
                        $("#btnSave").html('Simpan');
                    }
                });
            });

            $('body').on('click', '.deleteData', function() {
                var data_id = $(this).data("id");
                if (confirm("Apakah Anda yakin?")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('staff.store') }}" + "/" + data_id,
                        success: function(data) {
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error', data);
                        }
                    });
                } else {
                    return false;
                }
            });

            $('body').on('click', '.editData', function() {
                var data_id = $(this).data("id");
                $.get("{{ route('staff.index') }}" + "/" + data_id + "/edit", function(data) {
                    $("#modalHeading").html("Ubah Data");
                    $("#ajaxModal").modal('show');
                    $("#data_id").val(data.id);
                    $("#nik").val(data.nik);
                    $("#name").val(data.name);
                    $("#corp").val(data.corp);
                    $("#dept").val(data.dept);
                    $("#position").val(data.position);
                    $("#role").val(data.role);
                    $("#gender").val(data.gender);
                    $("#religion").val(data.religion);
                    $("#kk").val(data.kk);
                    $("#ktp").val(data.ktp);
                    $("#address").val(data.address);
                    $("#email").val(data.email);
                    $("#kontak").val(data.kontak);
                    $("#certi").val(data.certi);
                    $("#place").val(data.place);
                    $("#born").val(data.born);
                    $("#bill").val(data.bill);
                    $("#npwp").val(data.npwp);
                    $("#ptkp").val(data.ptkp);
                    $("#status").val(data.status);
                    $("#joindate").val(data.joindate);
                    $("#study").val(data.study);
                    $("#school").val(data.school);
                    $("#prodi").val(data.prodi);
                    $("#ijazah").val(data.ijazah);
                    $("#resign").val(data.resign);
                    $("#age").val(data.age.years+" year, "+data.age.months+" month");
                    $("#masa_kerja").val(data.masaKerja.years+" year, "+data.masaKerja.months+" month");
                    $("#bpjs_kes").val(data.bpjs_kesehatan);
                    $("#bpjs_tk").val(data.bpjs_tk);
                    $("#titip_ijazah").val(data.titip_ijazah);
                    $("#vaksin1").val(data.vaksin1);
                    $("#vaksin2").val(data.vaksin2);
                    $("#vaksin3").val(data.vaksin3);
                    $("#vaksin4").val(data.vaksin4);
                    $("#end_contract").val(data.end_contract);
                    $("#sp1").val(data.sp1);
                    $("#sp2").val(data.sp2);
                    $("#sp3").val(data.sp3);
                    const role = (data.role == null) ? "0" : data.role;
                    $("#role").val(role);
                    $("#tgl_ijazah").val(data.tgl_ijazah);
                    $("#nim").val(data.nim);
                    $("#kelurahan").val(data.kelurahan);
                    $("#kecamatan").val(data.kecamatan);
                    $("#kota").val(data.kota);
                    $("#propinsi").val(data.propinsi);
                    $("#vaksin_name").val(data.vaksin_name);
                    const is_vaksin1 = (data.is_vaksin1 == null) ? "" : data.is_vaksin1;
                    $("#is_vaksin1").val(is_vaksin1);
                    const is_vaksin2 = (data.is_vaksin2 == null) ? "" : data.is_vaksin2;
                    $("#is_vaksin2").val(is_vaksin2);
                    const is_vaksin3 = (data.is_vaksin3 == null) ? "" : data.is_vaksin3;
                    $("#is_vaksin3").val(is_vaksin3);
                    $("#pic_mesin").val(data.pic_mesin);
                });
            });

            $('body').on('click', '#showAlper', function() {
                window.location.href = '{{ route('staffResign.all', ['id' => 'alper']) }}';
            });

            $('body').on('click', '#showLegano', function() {
                window.location.href = '{{ route('staffResign.all', ['id' => 'legano']) }}';
            });

            $('body').on('click', '#showLegano5', function() {
                window.location.href = '{{ route('staffResign.all', ['id' => 'legano5']) }}';
            });

            $('body').on('click', '#showAll', function() {
                window.location.href = '{{ route('staffResign.all', ['id' => 'all']) }}';
            });

            function calculateAge(dateOfBirth) {
                var now = new Date();
                var today = new Date(now.getYear(),now.getMonth(),now.getDate());

                var yearNow = now.getYear();
                var monthNow = now.getMonth();
                var dateNow = now.getDate();

                var dob = new Date(dateOfBirth);

                var yearDob = dob.getYear();
                var monthDob = dob.getMonth();
                // var dateDob = dob.getDate();
                var age = {};
                var ageString = "";
                var yearString = "";
                var monthString = "";
                // var dayString = "";

                yearAge = yearNow - yearDob;

                if (monthNow >= monthDob)
                    var monthAge = monthNow - monthDob;
                else {
                    yearAge--;
                    var monthAge = 12 + monthNow -monthDob;
                }

                // if (dateNow >= dateDob)
                //     var dateAge = dateNow - dateDob;
                // else {
                //     monthAge--;
                //     var dateAge = 31 + dateNow - dateDob;

                //     if (monthAge < 0) {
                //         monthAge = 11;
                //         yearAge--;
                //     }
                // }

                age = {
                    years: yearAge,
                    months: monthAge,
                    // days: dateAge
                 };

                if ( age.years > 1 ) yearString = " year";
                    else yearString = " year";
                if ( age.months> 1 ) monthString = " month";
                    else monthString = " month";
                // if ( age.days > 1 ) dayString = " days";
                // else dayString = " day";


                if ( (age.years > 0) && (age.months > 0) )
                    ageString = age.years + yearString + ", " + age.months + monthString + "";
                else if ( (age.years == 0) && (age.months == 0) )
                    ageString = "Only " + age.days + dayString + "";
                else if ( (age.years > 0) && (age.months == 0) )
                    ageString = age.years + yearString + "";
                else if ( (age.years > 0) && (age.months > 0) )
                    ageString = age.years + yearString + "";
                else if ( (age.years == 0) && (age.months > 0) )
                    ageString = age.months + monthString + "";
                else if ( (age.years > 0) && (age.months == 0) )
                    ageString = age.years + yearString + "";
                else if ( (age.years == 0) && (age.months > 0) )
                    ageString = age.months + monthString + "";
                else ageString = "Oops! Could not calculate age!";

                return ageString;
            }

            $("#born").on('change', function(){
                const age = calculateAge($(this).val());
                $("#age").val(age);
            });

            $("#joindate").on('change', function(){
                const age = calculateAge($(this).val());
                $("#masa_kerja").val(age);
            });
        });
    </script>

@stop
