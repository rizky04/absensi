<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Http\Requests\StoreIzinRequest;
use App\Http\Requests\UpdateIzinRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $izin = DB::table('izins')->where('nik', $nik)->get();
        return view('izin.index', compact('izin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('izin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;
        $data = [
            'nik' => $nik,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        $simpan = DB::table('izins')->insert($data);
        if ($simpan) {
            return redirect('izin')->with(['success' => 'Data Berhasil Disimpan']);
        }else {
            return redirect('izin.create')->with(['error' => 'Data Gagal Disimpan']);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Izin $izin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Izin $izin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIzinRequest $request, Izin $izin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Izin $izin)
    {
        //
    }
}
