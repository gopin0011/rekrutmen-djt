<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aplikasi Pelamar - {{ $item['user']->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body{
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color:#333;
            text-align:left;
            font-size: 8pt;
            margin:0;
        }
        .container{
            margin:0 auto;
            margin-top:10px;
            padding:0px;
            width:750px;
            height:auto;
            background-color:#fff;
        }
        caption{
            font-size: 8pt;
            margin-bottom:15px;
        }
        table{
            border:0px solid #333;
            border-collapse:collapse;
            margin:0 auto;
            width:100%;
        }
        th{
            padding:3px;
            border:1px solid #aaaaaa;
            font-size: 8pt;
            background-color: #cccccc;
        }

        tr{
            padding:3px;
            font-size: 8pt;
        }

        td {
            padding:3px;
            font-size: 8pt;
        }

        h4, p{
            margin:0px;

        }
        table{
            border: 0px;
            margin-top: 10px;
            margin-left: 0cm;
            margin-right: 2cm;
            page-break-inside: avoid;
        }

        tbody{
            text-align: center;
        }

        .page-break {
            page-break-after: always;
        }
        @page { margin: 150px 50px; }
        header { position: fixed; top: -100px; left: 0px; right: 0px; height: auto; }
        footer { position: fixed; bottom: -100px; left: 0px; right: 0px; height: 50px; }
        p { page-break-after: always; }
        p:last-child { page-break-after: never; }
    </style>
</head>

<body>
    <header>
        <table>
            <tr>
                <td style="text-align: left"><img src="logo.png" width="250"></td>
                <td><h2>APLIKASI PELAMAR</h2></td>
            </tr>
        </table>
    </header>

    <table>
            <tr>
                <td style="width: auto; text-align: right">Posisi yang dilamar</td>
                <td style="width:5px;">:</td>
                <td style="width: 120px; text-align: left;">{{ $item['posisi'] }}</td>
            </tr>
            <tr>
                <td style="width: auto; text-align: right">Posisi lain yang diminati</td>
                <td style="width:5px">:</td>
                <td style="width: 120px; text-align: left;">{{ $item['posisialt'] }}</td>
            </tr>
            <tr>
                <td style="width: auto; text-align: right">Sumber informasi lowongan</td>
                <td style="width:5px">:</td>
                <td style="width: 120px; text-align: left;">{{ $item['data']->info }}</td>
            </tr>
            <tr>
                <td style="width: auto; text-align: right">Memiliki kerabat/saudara di PT. Dwida Jaya Tama</td>
                <td style="width:5px">:</td>
                <td style="width: 120px; text-align: left;">
                    @if( $item['data']->kerabat == null)
                        {{ 'Tidak' }}
                    @else
                        {{ 'Ya' }}
                    @endif
                </td>
            </tr>

            <tr>
                <td style="width: auto; text-align: right">Jika "Ya", tuliskan nama dan posisinya</td>
                <td style="width:5px">:</td>
                <td style="width: 120px; text-align: left;">{{ $item['data']->kerabat }}</td>
            </tr>

            <tr>
                <td style="width: auto; text-align: right">Jadwal interview</td>
                <td style="width:10px">:</td>
                <td style="width: 120px; text-align: left;"><strong>{{ $item['tanggal'] }}</strong></td>
            </tr>
    </table>

    <table>
        <tbody style="border:1pt solid #000000">
            <tr>
                <td colspan="9" style="text-align: center; border:1pt solid #000000;background:lightgray"><h4>IDENTITAS DIRI</h4></td>
            </tr>

            <tr>
                <td style="text-align: left; width:120px">Nama Lengkap</td>
                <td style="width:10px">:</td>
                <td style="text-align: left; width:auto" colspan="4">{{ $item['user']->name }}</td>
                <td style="text-align: left; width:100px">Panggilan</td>
                <td style="width:10px">:</td>
                <td style="text-align: left; width:100px">{{ $item['profil']->panggilan ?? ''}}</td>
            </tr>
            <tr>
                <td style="text-align: left; width:120px">e-Mail</td>
                <td style="width:10px">:</td>
                <td style="text-align: left; width:auto" colspan="7">{{ $item['user']->email }}</td>
            </tr>
            <tr>
                <td style="text-align: left; width:120px">Jenis Kelamin</td>
                <td style="width:10px">:</td>
                <td style="text-align: left; width:auto" colspan="4">{{ $item['gender'] ?? ''}}</td>
                <td style="text-align: left">Kewarganegaraan</td>
                <td style="width:10px">:</td>
                <td style="text-align: left; width:auto">{{ $item['profil']->wn ?? ''}}</td>
            </tr>
            <tr>
                <td style="text-align: left; width:120px">Tempat, Tanggal Lahir</td>
                <td style="width:10px">:</td>
                <td style="text-align: left; width:auto">{{ $item['profil']->tempatlahir ?? ''}}, {{ $item['tanggallahir'] }}</td>

                <td style="text-align: left">Agama</td>
                <td style="width:5px">:</td>
                <td style="text-align: left; width:100px">{{ $item['agama'] ?? ''}}</td>

                <td style="text-align: left">Golongan Darah</td>
                <td style="width:10px">:</td>
                <td style="text-align: left">{{ $item['profil']->darah ?? ''}}</td>
            </tr>
            <tr>
                <td style="text-align: left; width:120px">Nomor KTP</td>
                <td style="width:10px">:</td>
                <td style="text-align: left" colspan="7">{{ $item['profil']->nik ?? ''}}</td>
            </tr>
            <tr>
                <td style="text-align: left">Alamat sesuai KTP</td>
                <td style="width:10px">:</td>
                <td style="text-align: left" colspan="7">{{ $item['profil']->alamat ?? ''}}</td>
            </tr>
            <tr>
                <td style="text-align: left">Alamat Domisili</td>
                <td style="width:10px">:</td>
                <td style="text-align: left" colspan="7">{{ $item['profil']->domisili ?? ''}}</td>
            </tr>
            <tr>
                <td style="text-align: left; width:120px">Nomor Kontak</td>
                <td style="width:10px">:</td>
                <td style="text-align: left" colspan="7">{{ $item['profil']->kontak ?? ''}}</td>
            </tr>
            <tr>
                <td style="text-align: left">Status Perkawinan</td>
                <td style="width:10px">:</td>
                <td style="text-align: left" colspan="7">{{ $item['profil']->status ?? ''}}</td>
            </tr>
            <tr>
                <td style="text-align: left">Hobi</td>
                <td style="width:10px">:</td>
                <td style="text-align: left" colspan="7">{{ $item['profil']->hobi ?? ''}}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <tbody style="border:1pt solid #000000">
            <tr>
                <td colspan="6" style="text-align: center; border:1pt solid #000000;background:lightgray"><h4>SUSUNAN ANGGOTA KELUARGA (TERMASUK DIRI ANDA)</h4></td>
            </tr>
            <tr>
                <th style="width: 75px;border:1pt solid #000000">Hubungan Keluarga</th>
                <th style="border:1pt solid #000000">Nama</th>
                <th style="width: 30px;border:1pt solid #000000">L/P</th>
                <th style="width: 150px;border:1pt solid #000000">Tempat/Tanggal Lahir</th>
                <th style="width: 75px;border:1pt solid #000000">Pendidikan</th>
                <th style="width: 75px;border:1pt solid #000000">Pekerjaan</th>
            </tr>
            @if ($item['ayah'])
            <tr>
                <td style="border:1pt solid #000000">Ayah</td>
                <td style="border:1pt solid #000000">{{ $item['ayah']->nama}}</td>
                <td style="border:1pt solid #000000">{{ $item['ayah']->gender == 'Pria' ? 'L' : 'P'}}</td>
                <td style="border:1pt solid #000000">{{ $item['ayah']->ttl}}</td>
                <td style="border:1pt solid #000000">{{ $item['ayah']->pendidikan}}</td>
                <td style="border:1pt solid #000000">{{ $item['ayah']->pekerjaan}}</td>
            </tr>
            @endif
            $@if ($item['ibu'])
            <tr>
                <td style="border:1pt solid #000000">Ibu</td>
                <td style="border:1pt solid #000000">{{ $item['ibu']->nama}}</td>
                <td style="border:1pt solid #000000">{{ $item['ibu']->gender == 'Pria' ? 'L' : 'P'}}</td>
                <td style="border:1pt solid #000000">{{ $item['ibu']->ttl}}</td>
                <td style="border:1pt solid #000000">{{ $item['ibu']->pendidikan}}</td>
                <td style="border:1pt solid #000000">{{ $item['ibu']->pekerjaan}}</td>
            </tr>
            @endif
            {{ $i = 1; }}
            @foreach ($item['kakak'] as $row)
            <tr>
                <td style="border:1pt solid #000000">anak {{ $i++ }}</td>
                <td style="border:1pt solid #000000">{{ $row->nama}}</td>
                <td style="border:1pt solid #000000">{{ $row->gender == 'Pria' ? 'L' : 'P'}}</td>
                <td style="border:1pt solid #000000">{{ $row->ttl}}</td>
                <td style="border:1pt solid #000000">{{ $row->pendidikan}}</td>
                <td style="border:1pt solid #000000">{{ $row->pekerjaan}}</td>
            </tr>
            @endforeach
            <tr>
                <td style="border:1pt solid #000000">anak {{ $i++ }}</td>
                <td style="border:1pt solid #000000">{{ $item['user']->name}}</td>
                <td style="border:1pt solid #000000">{{ $item['profil']->gender ?? '' == '0' ? 'L' : 'P'}}</td>
                <td style="border:1pt solid #000000">{{ $item['profil']->tempatlahir ?? ''}},{{ $item['tanggallahir']}}</td>
                <td style="border:1pt solid #000000">{{ $item['study'][0]->tingkat ?? ''}}</td>
                <td style="border:1pt solid #000000"></td>
                {{-- <td style="border:1pt solid #000000">{{ $row->pekerjaan}}</td> --}}
            </tr>
            @foreach ($item['adik'] as $row)
            <tr>
                <td style="border:1pt solid #000000">anak {{ $i++ }}</td>
                <td style="border:1pt solid #000000">{{ $row->nama}}</td>
                <td style="border:1pt solid #000000">{{ $row->gender == 'Pria' ? 'L' : 'P'}}</td>
                <td style="border:1pt solid #000000">{{ $row->ttl}}</td>
                <td style="border:1pt solid #000000">{{ $row->pendidikan}}</td>
                <td style="border:1pt solid #000000">{{ $row->pekerjaan}}</td>
            </tr>
            @endforeach
        </tbody>
        <tr>
            <td colspan="6" style="color: white">.</td>
        </tr>
    </table>

    @if ($item['profil']->status ?? 'Lajang' != 'Lajang')
    <table>
        <tbody style="border:1pt solid #000000">
            <tr>
                <td colspan="6" style="text-align: center; border:1pt solid #000000;background:lightgray"><h4>DIISI BILA SUDAH MENIKAH</h4></td>
            </tr>
            <tr>
                <th style="width: 75px;border:1pt solid #000000">Hubungan Keluarga</th>
                <th style="border:1pt solid #000000">Nama</th>
                <th style="width: 30px;border:1pt solid #000000">L/P</th>
                <th style="width: 150px;border:1pt solid #000000">Tempat/Tanggal Lahir</th>
                <th style="width: 75px;border:1pt solid #000000">Pendidikan</th>
                <th style="width: 75px;border:1pt solid #000000">Pekerjaan</th>
            </tr>
            <tr>
                <td style="border:1pt solid #000000">{{ $item['pasangan']->status ?? ''}}</td>
                <td style="border:1pt solid #000000">{{ $item['pasangan']->nama ?? ''}}</td>
                <td style="border:1pt solid #000000">{{ $item['pasangan']->gender  ?? '' == 'Pria' ? 'L' : 'P' }}</td>
                <td style="border:1pt solid #000000">{{ $item['pasangan']->ttl ?? ''}}</td>
                <td style="border:1pt solid #000000">{{ $item['pasangan']->pendidikan ?? ''}}</td>
                <td style="border:1pt solid #000000">{{ $item['pasangan']->pekerjaan ?? ''}}</td>
            </tr>
            {{ $x = 1; }}
            @foreach ($item['anak'] as $row)
            <tr>
                <td style="border:1pt solid #000000">item['anak'] {{ $x++ }}</td>
                <td style="border:1pt solid #000000">{{ $row->nama}}</td>
                <td style="border:1pt solid #000000">{{ $row->gender == 'Pria' ? 'L' : 'P'}}</td>
                <td style="border:1pt solid #000000">{{ $row->ttl}}</td>
                <td style="border:1pt solid #000000">{{ $row->pendidikan ?? 'Tidak sekolah'}}</td>
                <td style="border:1pt solid #000000">{{ $row->pekerjaan}}</td>
            </tr>
            @endforeach
        </tbody>
        <tr>
            <td colspan="6" style="color: white">.</td>
        </tr>
    </table>
    @endif

    {{--  --}}

    <table>
        <tbody style="border:1pt solid #000000">
            <tr>
                <td colspan="6" style="text-align: center; border:1pt solid #000000;background:lightgray"><h4>LATAR BELAKANG PENDIDIKAN FORMAL</h4></td>
            </tr>
            <tr>
                <th style="width: 75px;border:1pt solid #000000">Jenjang</th>
                <th style="border:1pt solid #000000">Nama Sekolah</th>
                <th style="width: 125px;border:1pt solid #000000">Kota</th>
                <th style="width: 75px;border:1pt solid #000000">Jurusan/Fakultas</th>
                <th style="width: 75px;border:1pt solid #000000">Masuk</th>
                <th style="width: 75px;border:1pt solid #000000">Keluar</th>
            </tr>
            @forelse ($item['study'] as $row)
            <tr>
                <td style="border:1pt solid #000000">{{ $row->tingkat}}</td>
                <td style="border:1pt solid #000000">{{ $row->sekolah}}</td>
                <td style="border:1pt solid #000000">{{ $row->kota}}</td>
                <td style="border:1pt solid #000000">{{ $row->jurusan}}</td>
                <td style="border:1pt solid #000000">{{ $row->masuk}}</td>
                <td style="border:1pt solid #000000">{{ $row->keluar}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Data belum lengkap.</td>
            </tr>
            @endforelse
        </tbody>
        <tr>
            <td colspan="6" style="color: white">.</td>
        </tr>
    </table>

    <table>
        <tbody style="border:1pt solid #000000">
            <tr>
                <td colspan="5" style="text-align: center; border:1pt solid #000000;background:lightgray"><h4>PENDIDIKAN NON-FORMAL (KURSUS / SEMINAR / PENATARAN)</h4></td>
            </tr>
            <tr>
                <th style="border:1pt solid #000000">Pendidikan</th>
                <th style="width: 75px;border:1pt solid #000000">Tahun</th>
                <th style="width: 75px;border:1pt solid #000000">Durasi</th>
                <th style="width: 75px;border:1pt solid #000000">Ijazah</th>
                <th style="width: 75px;border:1pt solid #000000">Sumber Biaya</th>
            </tr>
            @forelse ($item['training'] as $row)
            <tr>
                <td style="border:1pt solid #000000">{{ $row->kursus}}</td>
                <td style="border:1pt solid #000000">{{ $row->tahun}}</td>
                <td style="border:1pt solid #000000">{{ $row->durasi}}</td>
                <td style="border:1pt solid #000000">{{ $row->ijazah}}</td>
                <td style="border:1pt solid #000000">{{ $row->biaya}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada pendidikan non-formal yang diikuti.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table>
        <tbody style="border:1pt solid #000000">
            <tr>
                <td colspan="5" style="text-align: center; border:1pt solid #000000;background:lightgray"><h4>KEMAMPUAN BAHASA</h4></td>
            </tr>
            <tr>
                <th style="border:1pt solid #000000">Bahasa</th>
                <th style="width: 75px;border:1pt solid #000000">Bicara</th>
                <th style="width: 75px;border:1pt solid #000000">Membaca</th>
                <th style="width: 75px;border:1pt solid #000000">Menulis</th>
                <th style="width: auto;border:1pt solid #000000">Keterangan</th>
            </tr>
            @forelse ($item['language'] as $row)
            <tr>
                <td style="border:1pt solid #000000">{{ $row->bahasa}}</td>
                <td style="border:1pt solid #000000">{{ $row->bicara}}</td>
                <td style="border:1pt solid #000000">{{ $row->baca}}</td>
                <td style="border:1pt solid #000000">{{ $row->tulis}}</td>
                <td style="border:1pt solid #000000">{{ $row->catatan}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Data belum lengkap.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table>
        <tbody style="border:1pt solid #000000">
            <tr>
                <td colspan="4" style="text-align: center; border:1pt solid #000000;background:lightgray"><h4>KEGIATAN SOSIAL/POLITIK/PROFESIONAL YANG PERNAH DIIKUTI</h4></td>
            </tr>
            <tr>
                <th style="border:1pt solid #000000">Kegiatan</th>
                <th style="width: 100px;border:1pt solid #000000">Tahun</th>
                <th style="width: auto;border:1pt solid #000000">Jabatan</th>
                <th style="width: auto;border:1pt solid #000000">Keterangan</th>
            </tr>
            @forelse ($item['activity'] as $row)
            <tr>
                <td style="border:1pt solid #000000">{{ $row->kegiatan}}</td>
                <td style="border:1pt solid #000000">{{ $row->tahun}}</td>
                <td style="border:1pt solid #000000">{{ $row->jabatan}}</td>
                <td style="border:1pt solid #000000">{{ $row->catatan}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Data belum lengkap.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table>
        <tbody style="border:1pt solid #000000">
            <tr>
                <td colspan="4" style="text-align: center; border:1pt solid #000000;background:lightgray"><h4>REFERENSI</h4></td>
            </tr>
            <tr>
                <th style="border:1pt solid #000000">Nama</th>
                <th style="width: 150px;border:1pt solid #000000">Perusahaan</th>
                <th style="width: 100px;border:1pt solid #000000">Kontak</th>
                <th style="width: 150px;border:1pt solid #000000">Jabatan / Posisi</th>
            </tr>
            @forelse ($item['reference'] as $row)
            <tr>
                <td style="border:1pt solid #000000">{{ $row->nama}}</td>
                <td style="border:1pt solid #000000">{{ $row->perusahaan}}</td>
                <td style="border:1pt solid #000000">{{ $row->kontak}}</td>
                <td style="border:1pt solid #000000">{{ $row->jabatan}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada referensi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table>
        <tbody style="border:1pt solid #000000">
            <tr>
                <td colspan="9" style="text-align: center; border:1pt solid #000000;background:lightgray"><h4>RIWAYAT PEKERJAAN</h4></td>
            </tr>

            @forelse ($item['career'] as $row)
           <tr>
               <td style="text-align: left; width:200px">Nama Perusahaan</td>
               <td style="width: 20px">:</td>
               <td colspan="7" style="text-align: left">{{ $row->perusahaan}}</td>
           </tr>
           <tr>
                <td style="text-align: left">Alamat Perusahaan</td>
                <td>:</td>
                <td colspan="7" style="text-align: left">{{ $row->alamat}}</td>
            </tr>
            <tr>
                <td style="text-align: left">Jabatan / Posisi</td>
                <td>:</td>
                <td colspan="7" style="text-align: left">{{ $row->jabatan}}</td>
            </tr>
            <tr>
                <td style="text-align: left">Periode</td>
                <td>:</td>
                <td colspan="7" style="text-align: left">{{ $row->masuk}} - {{ $item['data']->keluar}}</td>
            </tr>
            <tr>
                <td style="text-align: left">Total Gaji dan Tunjangan</td>
                <td>:</td>
                <td colspan="7" style="text-align: left">@if(is_int($row->gaji)) Rp. {{ number_format(str_replace('.', '', $row->gaji)) }} @else {{$row->gaji}} @endif</td>
            </tr>
            <tr>
                <td style="text-align: left">Detail Pekerjaan</td>
                <td>:</td>
                <td colspan="7" style="text-align: left">{{ $row->pekerjaan}}</td>
            </tr>
            <tr>
                <td style="text-align: left">Prestasi</td>
                <td>:</td>
                <td colspan="7" style="text-align: left">{{ $row->prestasi}}</td>
            </tr>
            <tr>
                <td style="text-align: left">Alasan Pengunduran Diri</td>
                <td>:</td>
                <td colspan="7" style="text-align: left">{{ $row->alasan}}</td>
            </tr>
            <tr>
                <td colspan="9" style="text-align: center;border:1pt solid #000000"></td>
            </tr>
            @empty
            <tr>
                <td class="text-center">Belum mempunyai riwayat pekerjaan.</td>
            </tr>
            @endforelse
        </tbody>
        <tr>
            <td colspan="9" style="color: white">.</td>
        </tr>
    </table>

    <table>
        <tbody style="border:1pt solid #000000">
            <tr>
                <td style="text-align: center; border:1pt solid #000000;background:lightgray"><h4>INFORMASI DIRI LAINNYA</h4></td>
            </tr>

            @foreach ($item['quest'] as $row)
            <tr>
                <td style="text-align: left; width:200px"><strong>1. Apa alasan Anda bersedia mengikuti proses rekrutmen di PT. Dwida Jaya Tama?</strong></td>
            </tr>
            <tr>
                <td style="text-align: left">{{ $row->alasan }}</td>
            </tr>
             <tr>
                <td style="text-align: left; width:200px"><strong>2. Sebutkan bidang yang menjadi minat Anda dalam bekerja, jelaskan!</strong></td>
            </tr>
            <tr>
                <td style="text-align: left">{{ $row->bidang }}</td>
            </tr>
             <tr>
                <td style="text-align: left; width:200px"><strong>3. Apa rencana Anda dalam 3 - 5 tahun ke depan?</strong></td>
            </tr>
            <tr>
                <td style="text-align: left">{{ $row->rencana }}</td>
            </tr>
             <tr>
                <td style="text-align: left; width:200px"><strong>4. Prestasi apa saja yang pernah Anda raih?</strong></td>
            </tr>
            <tr>
                <td style="text-align: left">{{ $row->prestasi }}</td>
            </tr>
             <tr>
                <td style="text-align: left; width:200px"><strong>5. Apakah saat ini, Anda melamar pekerjaan di perusahaan selain PT. Dwida Jaya Tama? Jika ya, sebutkan!</strong></td>
            </tr>
            <tr>
                <td style="text-align: left">{{ $row->lamaran }}</td>
            </tr>
             @endforeach
        </tbody>
    </table>
    <div class="page-break"></div>
    <table>
        <tbody style="border:1pt solid #000000">
            <tr>
                <td style="text-align: center; border:1pt solid #000000;background:lightgray"><h4>GAMBARAN DIRI</h4></td>
            </tr>

            @foreach ($item['quest'] as $row)
            <tr>
                <td style="text-align: left; width:200px"><strong>Berikan gambaran mengenai diri Anda, mencakup: kehidupan keluarga, hobi, tokoh yang menginspirasi, kondisi yang tidak sesuai dengan harapan di tempat kerja saat ini dan diharapkan di PT. Dwida Jaya Tama, dan kontribusi yang dapat diberikan kepada PT. Dwida Jaya Tama apabila bergabung.</strong></td>
            </tr>
            <tr>
                <td style="text-align: left">{{ $row->deskripsi }}</td>
            </tr>
             @endforeach
        </tbody>
    </table>

</object>
</body>

</html>
