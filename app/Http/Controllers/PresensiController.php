<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Http\Requests\StorePresensiRequest;
use App\Http\Requests\UpdatePresensiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
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
        $hariini = date('Y-m-d');
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensis')->where('nik', $nik)->where('tgl_presensi', $hariini)->count();
        return view('presensi.create', compact('cek'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        $countPhoto = date('H-i-s');

        $latitudekantor = -7.326446888913083;
        $longitudekantor = 112.74468344292505;
        $lokasi = $request->lokasi;
        $lokasiuser = explode(',', $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];
        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);

        $cek = DB::table('presensis')->where('nik', $nik)->where('tgl_presensi', $tgl_presensi)->count();
        if ($cek > 0) {
           $ket = "out";
        } else {
            $ket = "in";
        }


        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi . "-" . $countPhoto . "-" . $ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;


        if ($radius > 50) {
            echo "error|Maaf Anda Berada Diluar Radius, JArak Anda " . $radius . " meter dari kantor|radius";
        } else {
            if ($cek > 0) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi,
                ];
                $simpan = DB::table('presensis')->where('nik', $nik)->where('tgl_presensi', $tgl_presensi)->update($data_pulang);
                if ($simpan) {
                    echo "success|Terimakasih, Hati Hati Di Jalan|out";
                    Storage::put($file, $image_base64);
                }else{
                    echo "error|Maaf Gagal absen, Hubungi Tim IT|out";
                }
            }else{
                $data = [
                    'nik' => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi,
                ];
                $simpan = DB::table('presensis')->insert($data);
                if ($simpan) {
                    echo "success|Terimakasih, Selamat Bekerja|in";
                    Storage::put($file, $image_base64);
                }else{
                    echo "error|Maaf Gagal absen, Hubungi Tim IT|in";
                }
            }
        }
    }

    // menghitung jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }


    /**
     * Display the specified resource.
     */
    public function show(Presensi $presensi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presensi $presensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePresensiRequest $request, Presensi $presensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presensi $presensi)
    {
        //
    }

    public function history(Request $request){
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $years = range(date('Y'), 2023);

        return view('presensi.history', compact('namabulan', 'years'));
    }

    public function gethistori(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $histori = DB::table('presensis')
                    ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
                    ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
                    ->where('nik', $nik)
                    ->orderBy('tgl_presensi')
                    ->get();

        return view('presensi.getdata', compact('histori'));
        // $bulan = $request->bulan;
        // $tahun = $request->tahun;
        // $nik = Auth::guard('karyawan')->user()->nik;

        // $histori = DB::table('presensis')
        //             ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
        //             ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
        //             ->where('nik', $nik)
        //             ->orderBy('tgl_presensi')
        //             ->get();

        // return response()->json($histori);
    }
}
