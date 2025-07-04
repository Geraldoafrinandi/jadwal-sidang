<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Tugas Seminar Proposal</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 1.5cm 1cm 4cm 1.5cm;
        }

        .kepala {
            position: fixed;
            top: 0;
            left: 56.8px;
            right: 56.8px;
            z-index: 0;
            border-collapse: collapse;
            border-left: none;
            border-top: none;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
        }

        .kepala table {
            border: none;
            width: 100%;
        }

        .kepala td.logo {
            text-align: center;
            padding: 0;
        }

        .kepala td.logo img {
            display: block;
            margin-left: 10px;
            margin-top: 10px;
            width: 120%;

        }

        .kepala td {
            padding: 0;
            text-align: center;
            border: none;

        }

        .kepala .header-content {
            vertical-align: top;
            padding-top: 10px;
        }

        .kepala tr {
            border: none;
        }


        .badan {
            top: 70px;
            position: relative;

        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            margin: 0;
            line-height: 1.6;
        }

        .details .label {
            /* font-weight: bold; */
        }

        .details-table {
            width: auto;
            margin-bottom: 20px;
            border-collapse: collapse;
            border: none;
            margin-bottom: 100px
        }

        .details-table td {
            padding: 0;
            line-height: 1.6;
            vertical-align: top;
            border: none;
        }

        .details-table .label {
            padding-right: 10px;
            white-space: nowrap;
        }

        .details-table .value {
            padding-left: 5px;
        }

        table .isi {
            page-break-inside: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        strong {
            font-weight: bold;
        }

        .no {
            width: 5%;
            overflow: hidden;
            text-align: center;
            border-left: 1px solid black;
        }

        .nama_dosen {
            max-width: 200px;
            overflow: hidden;
            text-align: justify;
        }

        .nip {
            max-width: 50px;
            overflow: hidden;
            text-align: justify;
            word-wrap: break-word;
        }

        .jabatan {
            max-width: 50px;
            overflow: hidden;
            text-align: justify;
            word-wrap: break-word;
        }

        .signatures {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            page-break-inside: avoid;
        }

        .signatures table {
            border: none;
            width: 100%;
        }

        .signatures .left,
        .signatures .right {
            width: 50%;
            text-align: right;
            border: none;
            page-break-inside: avoid;
            white-space: nowrap;
        }

        .signatures .right p {
            margin: 0;
        }

        .signatures .nama_kaprodi {
            /* margin: 0; */
            display: inline-block;
            border-bottom: 1px solid black;
            padding-bottom: 5px;
            width: fit-content;
            text-align: right;
            /* margin-top: 40px */
            /* margin-right: 45px */
        }

        .signatures .nip_kaprodi {
            margin: 0;
            display: block;
            text-align: right;
        }



        /* .signatures .right p:last-child {
            padding-top: 10px;
        } */

        .signatures .center {
            width: 100%;
            text-align: center;
            page-break-inside: avoid;
        }

        .signatures .center p {
            page-break-after: avoid;
        }
    </style>
</head>

<body>
    <div class="kepala">
        <table>
            <tr class="border-top">
                <td class="logo" rowspan="1" style="width: 15%;">
                    <img src="{{ public_path('admin/assets/images/logoPNP.png') }}" alt="Logo" />
                </td>
                <td class="header-content">
                    <center>
                        <strong>
                            <font style="font-size: 18px;">KEMENTRIAN PENDIDIKAN, KEBUDAYAAN,</font><br>
                            <font style="font-size: 18px;">RISET, DAN TEKNOLOGI</font><br>
                        </strong>
                        <strong>
                            <font style="font-size: 18px;">POLITEKNIK NEGERI PADANG</font>
                        </strong><br>
                        <strong>
                            <font style="font-size: 18px;">JURUSAN TEKNOLOGI INFORMASI</font>
                        </strong><br>
                        <font style="font-size: 15px;">Kampus Politeknik Negeri Padang Limau Manis, Padang, Sumatera
                            Barat</font><br>
                        <font style="font-size: 15px;">Telepon: (0751) 72590, Faks: (0751) 72576</font><br>
                        <font style="font-size: 15px;">
                            Laman: <a href="https://ti.pnp.ac.id"
                                style="color: blue; text-decoration: underline;">https://ti.pnp.ac.id</a> | Surel:
                            ti@pnp.ac.id
                        </font>
                    </center>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <br>
    <br>

    <div class="badan">
        <center>
            <h2 style="margin: 0;">SURAT TUGAS</h2>
            <font style="font-size: 15px; margin-top: 0; margin-bottom: 0;">Nomor: 772/PL9.5/PT/2024</font>
        </center>
        <br>
        <div>
            <font style="font-size: 15px;">Yang bertanda tangan di bawah ini Ketua Jurusan Teknologi Informasi
                menugaskan kepada :</font>
        </div>
        <br>

        <table class="isi">
            <thead >
                <tr class="table-info">
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                </tr>
            </thead>

            @php
                $counter = 1;
            @endphp
            <tbody >
                <tr class="table-light">
                    <td class="no">{{ $counter++ }}</td>
                    <td class="nama_dosen">{{ $mhsSempro->r_pembimbing_satu->nama_dosen ?? 'Tidak ada Dosen' }}</td>
                    <td class="nip">{{ $mhsSempro->r_pembimbing_satu->nidn ?? 'Tidak ada Nip' }}</td>
                    <td class="jabatan">Dosen Pembimbing</td>
                </tr>

                <tr class="table-light">
                    <td class="no">{{ $counter++ }}</td>
                    <td class="nama_dosen">{{ $mhsSempro->r_penguji->nama_dosen ?? 'Tidak ada Dosen' }}</td>
                    <td class="nip">{{ $mhsSempro->r_penguji->nidn ?? 'Tidak ada Nip' }}</td>
                    <td class="jabatan">Dosen Penguji</td>
                </tr>

            </tbody>
        </table><br>

        <div style="margin-bottom: 1%;">
            <font style="font-size: 15px;">Untuk melaksanakan Sidang Seminar Proposal bagi mahasiswa berikut:</font>
        </div>
        <br>

        <table class="details-table">
            <tr>
                <td class="label">Nama</td>
                <td class="value">: {{ $mhsSempro->r_mahasiswa->nama ?? 'Tidak ada Data' }}</td>
            </tr>
            <tr>
                <td class="label">NIM</td>
                <td class="value">: {{ $mhsSempro->r_mahasiswa->nim ?? 'Tidak ada Data' }}</td>
            </tr>
        </table>
    </div>

    <table class="isi">
        <thead>
            <tr class="table-info">
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Ruangan</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table-light">
                <td class="hari">
                    {{ \Carbon\Carbon::parse($mhsSempro->tgl_sidang)->locale('id')->translatedFormat('l') }}
                </td>
                <td class="tanggal_sidang">
                    {{ \Carbon\Carbon::parse($mhsSempro->tanggal_sempro)->format('d-m-Y') }}</td>
                <td class="jam">{{ $mhsSempro->r_sesi->jam ?? 'Tidak ada data' }}</td>
                <td class="ruangan">{{ $mhsSempro->r_ruangan->ruangan ?? 'Tidak ada data' }}</td>
            </tr>
        </tbody>
    </table>
    <br>


    <font style="font-size: 15px;">Demikian surat tugas ini dibuat, untuk dapat dilaksanakan sebaik-baiknya</font>

    <div class="signatures">
        <table style="width: 100%;">
            <tr>
                <td class="right" style="padding-left: 100px;">
                    <p>{{ now()->translatedFormat('l, d F Y') }}</p>
                    <p style="margin-right:45px; margin-top: 10px ">Ketua Prodi</p>
                    {{-- <br><br><br><br> --}}
                    <p class="nama_kaprodi" style="margin-right: 53px; margin-top: 50px; margin-left:50px">{{ $kaprodi->dosen->nama_dosen ?? 'Tidak ada data' }}</p>
                    <p class="nip_kaprodi" style="margin-right: 45px">{{ $kaprodi->jabatanPimpinan->jabatan_pimpinan ?? 'Tidak ada data' }}</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>


{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Tugas PKL</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 1.5cm 1cm 4cm 1.5cm;
        }

        .kepala {
            position: fixed;
            top: 0;
            left: 56.8px;
            right: 56.8px;
            z-index: 0;
            border-collapse: collapse;
            border-left: none;
            border-top: none;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
        }

        .kepala table {
            border: none;
            width: 100%;
        }

        .kepala td.logo {
            text-align: center;
            padding: 0;
        }

        .kepala td.logo img {
            display: block;
            margin-left: 10px;
            margin-top: 10px;
            width: 120%;

        }

        .kepala td {
            padding: 0;
            text-align: center;
            border: none;

        }

        .kepala .header-content {
            vertical-align: top;
            padding-top: 10px;
        }

        .kepala tr {
            border: none;
        }


        .badan {
            top: 70px;
            position: relative;

        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            margin: 0;
            line-height: 1.6;
        }

        .details .label {
            /* font-weight: bold; */
        }

        .details-table {
            width: auto;
            margin-bottom: 20px;
            border-collapse: collapse;
            border: none;
        }

        .details-table td {
            padding: 0;
            line-height: 1.6;
            vertical-align: top;
            border: none;
        }

        .details-table .label {
            padding-right: 10px;
            white-space: nowrap;
        }

        .details-table .value {
            padding-left: 5px;
        }

        table .isi {
            page-break-inside: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        strong {
            font-weight: bold;
        }

        .no {
            width: 5%;
            overflow: hidden;
            text-align: center;
            border-left: 1px solid black;
        }

        .nama_dosen {
            max-width: 200px;
            overflow: hidden;
            text-align: justify;
        }

        .nip {
            max-width: 50px;
            overflow: hidden;
            text-align: justify;
            word-wrap: break-word;
        }

        .jabatan {
            max-width: 50px;
            overflow: hidden;
            text-align: justify;
            word-wrap: break-word;
        }

        .signatures {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            page-break-inside: avoid;
        }

        .signatures table {
            border: none;
            width: 100%;
        }

        .signatures .left,
        .signatures .right {
            width: 50%;
            text-align: right;
            border: none;
            page-break-inside: avoid;
            white-space: nowrap;
        }

        .signatures .right p {
            margin: 0;
        }

        .signatures .nama_kaprodi {
            margin: 0;
            display: inline-block;
            border-bottom: 1px solid black;
            padding-bottom: 5px;
            width: fit-content;
            text-align: right;
        }

        .signatures .nip_kaprodi {
            margin: 0;
            display: block;
            text-align: right;
        }



        /* .signatures .right p:last-child {
            padding-top: 10px;
        } */

        .signatures .center {
            width: 100%;
            text-align: center;
            page-break-inside: avoid;
        }

        .signatures .center p {
            page-break-after: avoid;
        }
    </style>
</head>

<body>



    <div class="kepala">
        <table>
            <tr class="border-top">
                <td class="logo" rowspan="1" style="width: 15%;">
                    <img src="{{ public_path('admin/assets/images/logo_pnp.png') }}" alt="Logo" />
                </td>
                <td class="header-content">
                    <center>
                        <strong>
                            <font style="font-size: 18px;">KEMENTRIAN PENDIDIKAN, KEBUDAYAAN,</font><br>
                            <font style="font-size: 18px;">RISET, DAN TEKNOLOGI</font><br>
                        </strong>
                        <strong>
                            <font style="font-size: 18px;">POLITEKNIK NEGERI PADANG</font>
                        </strong><br>
                        <strong>
                            <font style="font-size: 18px;">JURUSAN TEKNOLOGI INFORMASI</font>
                        </strong><br>
                        <font style="font-size: 15px;">Kampus Politeknik Negeri Padang Limau Manis, Padang, Sumatera
                            Barat</font><br>
                        <font style="font-size: 15px;">Telepon: (0751) 72590, Faks: (0751) 72576</font><br>
                        <font style="font-size: 15px;">
                            Laman: <a href="https://ti.pnp.ac.id"
                                style="color: blue; text-decoration: underline;">https://ti.pnp.ac.id</a> | Surel:
                            ti@pnp.ac.id
                        </font>

                    </center>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <br>
    <br>

    <div class="badan">
        <center>
            <h2 style="margin: 0;">SURAT TUGAS</h2>
            <font style="font-size: 15px; margin-top: 0; margin-bottom: 0;">Nomor: 772/PL9.5/PT/2024</font>
        </center>
        <br>
        <div>
            <font style="font-size: 15px;">Yang bertanda tangan di bawah ini Ketua Jurusan Teknologi Informasi
                menugaskan
                kepada :</font>
        </div>
        <br>

        <table class="isi">
            <thead>
                <tr class="table-info">
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                </tr>
            </thead>

            @php
                $counter = 1;
            @endphp
            <tbody>

                @foreach ($pembimbingList as $pembimbing)
                    <tr class="table-light">
                        <td class="no">{{ $counter++ }}</td>
                        <td class="nama_dosen">{{ $pembimbing->nama_dosen }}</td>
                        <td class="nip">{{ $pembimbing->nip }}</td>
                        <td class="jabatan">Dosen Pembimbing</td>
                    </tr>
                @endforeach

                @foreach ($pengujiList as $penguji)
                    <tr class="table-light">
                        <td class="no">{{ $counter++ }}</td>
                        <td class="nama_dosen">{{ $penguji->nama_dosen }}</td>
                        <td class="nip">{{ $penguji->nip }}</td>
                        <td class="jabatan">Dosen Penguji</td>
                    </tr>
                @endforeach
            </tbody>

        </table><br>

        <div style="margin-bottom: 1%;">
            <font style="font-size: 15px;">Untuk melaksanakan Sidang PKL Mahasiswa yang disebut dibawah ini</font>
        </div>



        <div class="details">
            <table class="details-table" style="padding-left: 20px;">
                @if ($data_sidang_pkl)
                    <tr>
                        <td class="label">Nama </td>
                        <td class="value">: {{ $data_sidang_pkl->r_pkl->r_mahasiswa->nama }}</td>
                    </tr>
                    <tr>
                        <td class="label">NIM</td>
                        <td class="value">: {{ $data_sidang_pkl->r_pkl->r_mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <td class="label">Program Studi</td>
                        <td class="value">: {{ $data_sidang_pkl->r_pkl->r_mahasiswa->r_prodi->prodi }}</td>
                    </tr>
                    <tr>
                        <td class="label">Judul Proyek PKL</td>
                        <td class="value">: {{ $data_sidang_pkl->judul }}</td>
                    </tr>
                @endif
            </table>
        </div>

        <table class="isi">
            <thead>
                <tr class="table-info">
                    <th>Hari</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Ruangan</th>
                </tr>
            </thead>
            <tbody>
                <tr class="table-light">
                    <td class="hari">
                        {{ \Carbon\Carbon::parse($data_sidang_pkl->tgl_sidang)->locale('id')->translatedFormat('l') }}
                    </td>
                    <td class="tanggal_sidang">
                        {{ \Carbon\Carbon::parse($data_sidang_pkl->tgl_sidang)->format('d-m-Y') }}</td>
                    <td class="jam">{{ $data_sidang_pkl->r_sesi->jam }}</td>
                    <td class="ruangan">{{ $data_sidang_pkl->r_ruang->kode_ruang }}</td>
                </tr>
            </tbody>
        </table>
        <br>


        <font style="font-size: 15px;">Demikian surat tugas ini dibuat, untuk dapat dilaksanakan sebaik-baiknya</font>

        <div class="signatures">
            <table style="width: 100%;">
                <tr>
                    <td class="right" style="padding-left: 100px;">
                        <p>Padang, 12 November 2024</p>
                        <p>Ketua Prodi</p>
                        <br><br><br><br>
                        <p class="nama_kaprodi">{{ $Kaprodi->r_dosen->nama_dosen }}</p>
                        <p class="nip_kaprodi">{{ $Kaprodi->r_dosen->nip }}</p>
                    </td>
                </tr>
            </table>
        </div>


</body>






</html> --}}
