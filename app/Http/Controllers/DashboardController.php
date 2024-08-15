<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hariini = date('Y-m-d');
        $bulanini = date("m") * 1;
        $tahunini = date("Y");

        $nik = Auth::guard('karyawan')->user()->nik;
        $presensihariini = DB::table('presensis')->where('nik', $nik)->where('tgl_presensi', $hariini)->first();

        $historibulanini = DB::table('presensis')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
        ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
        ->orderBy('tgl_presensi')
        ->get();

        $rekappresensi = DB::table('presensis')
        ->selectRaw('COUNT(nik) as jmlhadir, SUM(if(jam_in > "08:00", 1, 0)) as jmlterlambat')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
        ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
        ->first();

        $leaderboard = DB::table('presensis')
        ->join('karyawans', 'presensis.nik', '=', 'karyawans.nik')
        ->where('tgl_presensi', $hariini)
        ->orderBy('jam_in')
        ->get();

        $namabulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

        return view('dashboard.dashboard', compact('presensihariini', 'historibulanini', 'namabulan', 'hariini', 'bulanini', 'tahunini', 'rekappresensi', 'leaderboard'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
