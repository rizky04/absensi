<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKaryawanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $karyawan = Karyawan::where('nik', $id)->first();
        return view('karyawan.editprofile', compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request ,$id)
    {
       $nama_lengkap = $request->nama_lengkap;
       $no_hp = $request->no_hp;
       $password = Hash::make($request->password);
       $karyawan = DB::table('karyawans')->where('nik', $id)->first();

       if ($request->hasFile('foto')) {
        $foto = $id . "." . $request->file('foto')->getClientOriginalExtension();
       } else {
        $foto = $karyawan->foto;
       }

       if (empty($request->password)) {
        $data = [
            'nama_lengkap' => $nama_lengkap,
            'no_hp' => $no_hp,
        ];
       } else {
        $data = [
            'nama_lengkap' => $nama_lengkap,
            'no_hp' => $no_hp,
            'password' => $password,
        ];
       }

       $update = DB::table('karyawans')->where('nik', $id)->update($data);
       if ($update) {
       if ($request->hasFile('foto')) {
        $folderPath = "public/uploads/karyawan/";
        $request->file('foto')->move($folderPath, $foto);
       }
    return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
       } else {
        return Redirect::back()->with(['error' => 'Data Gagal Di Update']);
       }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        //
    }
}
