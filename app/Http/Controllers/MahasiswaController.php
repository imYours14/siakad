<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Storage;


class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // //fungsi eloquent menampilkan data menggunakan paginaon
        // $keyword = $request->keyword;
        // $mahasiswa = Mahasiswa::where('Nama', 'LIKE', '%'.$keyword.'%')->paginate(5); // Mengambil 5 isi tabel
        // // ----
        // $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(6);
        // return view('mahasiswa.index', compact('mahasiswa','keyword'))
        //         ->with('i', ($request->input('page', 1) - 1) * 5);
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::OrderBy('Nim', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate' => $paginate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('mahasiswa.create');
        $kelas = Kelas::all();
        return view('mahasiswa.create',['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Foto' => 'required|file|image|mimes:jpeg,png,jpg|max:1024',
            'TTL' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required'
        ]);
        // //fungsi eloquent untuk menambah data
        // Mahasiswa::create($request->all());
        $mahasiswa = new Mahasiswa;
        $mahasiswa -> Nim = $request->get('Nim');
        $mahasiswa -> Nama = $request ->get('Nama');
        $mahasiswa -> Foto = $request->file('Foto')->store('images', 'public');
        $mahasiswa -> TTL = $request ->get('TTL');
        $mahasiswa -> Jurusan =$request ->get('Jurusan');
        $mahasiswa -> No_Handphone = $request ->get('No_Handphone');
        $mahasiswa -> Email = $request ->get('Email');
        // $mahasiswa ->save();

        $kelas = new Kelas;
        $kelas->id = $request ->get('Kelas');

        $mahasiswa ->kelas()->associate($kelas);
        $mahasiswa->save();
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        // $Mahasiswa = Mahasiswa::find($Nim);
        // return view('mahasiswa.detail', compact('Mahasiswa'));
        $mahasiswa = Mahasiswa::with('Kelas')->where('Nim',$Nim)->first();
        return view('mahasiswa.detail', ['Mahasiswa'=>$mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        // $Mahasiswa = Mahasiswa::find($Nim);
        // return view('mahasiswa.edit', compact('Mahasiswa'));
        $Mahasiswa = Mahasiswa::with('Kelas')->where('Nim', $Nim)->first();
        $kelas = Kelas::all();
        return view('mahasiswa.edit', compact('Mahasiswa','kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
        'Nim' => 'required',
        'Nama' => 'required',
        'Foto' => 'required|file|image|mimes:jpeg,png,jpg|max:1024',
        'TTL' => 'required',
        'Kelas' => 'required',
        'Jurusan' => 'required',
        'No_Handphone' => 'required',
        'Email' => 'required'
        ]);

        $mahasiswa = Mahasiswa::with('Kelas')->where('Nim', $Nim)->first();
        $mahasiswa -> Nim = $request->get('Nim');
        $mahasiswa -> Nama = $request ->get('Nama');
        $mahasiswa -> TTL = $request ->get('TTL');
        $mahasiswa -> Jurusan =$request ->get('Jurusan');
        $mahasiswa -> No_Handphone = $request ->get('No_Handphone');
        $mahasiswa -> Email = $request ->get('Email');
        //$mahasiswa ->save();

        $kelas = new Kelas;
        $kelas->id = $request ->get('Kelas');

        $mahasiswa ->kelas()->associate($kelas);
        $mahasiswa->save();
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswa.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');

    }

    public function Mahasiswa_MataKuliah($Nim)
    {
        $mahasiswa = Mahasiswa::where('Nim', $Nim)->first();
        return view('mahasiswa.nilai', ['mahasiswa' => $mahasiswa]);
    }
}
