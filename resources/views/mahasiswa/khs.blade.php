<!DOCTYPE html>
<html>

<head>
    <title>Mencetak Laporan KARTU HASIL STUDI (KHS)</title>
</head>

<body>
    <center>
        <h2>KARTU HASIL STUDI (KHS)</h2>
    </center>
    <br>
        <b>Nama :</b> {{ $Mahasiswa->Nama}}<br>
        <b>NIM : </b>{{ $Mahasiswa->Nim}}<br>
        <b>Kelas : </b> {{ $Mahasiswa->Kelas->nama_kelas}}<br>

        <br><br><br>
        <table class="table table-bordered" width="700px">
            <tr>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Semester</th>
                <th>Nilai</th>
            </tr>
            <br>
                @foreach ($Mahasiswa -> matakuliah as $nilai)
                <tr>
                    <td>{{ $nilai->nama_matkul }}</td>
                    <td align="center">{{ $nilai->sks }}</td>
                    <td align="center">{{ $nilai->semester }}</td>
                    <td align="center">{{ $nilai->pivot->nilai }}</td>
                </tr>
            @endforeach
    </table>
</body>
</html>
