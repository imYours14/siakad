@extends('mahasiswa.layout') @section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            </div>
        </div>
    </div>

    <div class="float-left my-2">
        <form action="{{ route('mahasiswa.index') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="keyword" size="80" placeholder="Input Nama Mahasiswa">
                <div class="col-auto">
                    <button class="btn btn-info" type="submit">Pencarian</button>
                </div>
            </div>
        </form>
    </div>

    <div class="float-right my-2">
        <a class="btn btn-success" href="{{ route('mahasiswa.create') }}"> Input Mahasiswa</a>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Nim</th>
            <th>Nama</th>
            <th>Foto</th>
            <th>TTL</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>No_Handphone</th>
            <th>E-mail</th>
            <th width="400px">Action</th>
        </tr>
        @foreach ($paginate as $Mahasiswa)
            <tr>

                <td>{{ $Mahasiswa->Nim }}</td>
                <td>{{ $Mahasiswa->Nama }}</td>
                <td><img width="100px" height="100px" src="{{ asset('storage/' . $Mahasiswa->Foto) }}"></td>
                <td>{{ $Mahasiswa->TTL }}</td>
                <td>{{ $Mahasiswa->Kelas->nama_kelas }}</td>
                <td>{{ $Mahasiswa->Jurusan }}</td>
                <td>{{ $Mahasiswa->No_Handphone }}</td>
                <td>{{ $Mahasiswa->Email }}</td>
                <td>
                    <form action="{{ route('mahasiswa.destroy', $Mahasiswa->Nim) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('mahasiswa.show', $Mahasiswa->Nim) }}">Show</a>

                        <a class="btn btn-primary" href="{{ route('mahasiswa.edit', $Mahasiswa->Nim) }}">Edit</a>

                        <a class="btn btn-warning" href="{{ route('nilai', $Mahasiswa->Nim) }}"> Nilai</a>
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $paginate->links() }}
@endsection
