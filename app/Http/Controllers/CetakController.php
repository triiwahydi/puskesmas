<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use PDF;
use Carbon\Carbon;

class CetakController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        if (Auth::user()->role == 'admin') {
            $pelayanan = DB::table('pelayanan')
                ->select('pelayanan.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.nama', 'pasien.alamat') // Select all columns from both tables
                ->join('pasien', 'pelayanan.pasien_id', '=', 'pasien.id') // Join based on the foreign key relationship
                ->whereNull('pelayanan.deleted_at')
                ->whereNull('pasien.deleted_at')
                ->whereMonth('pelayanan.created_at', $currentMonth)
                ->whereYear('pelayanan.created_at', $currentYear)
                ->orderBy('pelayanan.created_at', 'desc')
                ->get();
            return view('cetak.cetak_pelayanan_admin_view')->with(compact('pelayanan'));
        }
        if (Auth::user()->role == 'dokter') {
            $pemeriksaan = DB::table('pemeriksaan')
                ->select('pemeriksaan.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.nama', 'pasien.alamat') // Select all columns from both tables
                ->join('pasien', 'pemeriksaan.pasien_id', '=', 'pasien.id') // Join based on the foreign key relationship
                ->where('tujuan', Auth()->user()->jabatan)
                ->whereNull('pemeriksaan.deleted_at')
                ->whereNull('pasien.deleted_at')
                ->whereMonth('pemeriksaan.created_at', $currentMonth)
                ->whereYear('pemeriksaan.created_at', $currentYear) // Filter for today's date in the 'pemeriksaan' table
                ->orderBy('pemeriksaan.created_at', 'desc')
                ->get();
            return view('cetak.cetak_pemeriksaan_dokter_view')->with(compact('pemeriksaan'));
        }
        if (Auth::user()->role == 'apoteker') {
            $obat = DB::table('obat')
                ->select('obat.*', 'pasien.id as pasien_id','pemeriksaan.id as pemeriksaan_id', 'pemeriksaan.tujuan','pasien.nik', 'pasien.nama', 'pasien.alamat', 'pemeriksaan.diagnosa')
                ->join('pasien', 'obat.pasien_id', '=', 'pasien.id')
                ->join('pemeriksaan', 'obat.pemeriksaan_id', '=', 'pemeriksaan.id')
                ->whereNull('obat.deleted_at')
                ->whereNull('pasien.deleted_at')
                ->whereNull('pemeriksaan.deleted_at')
                ->whereMonth('obat.created_at', $currentMonth)
                ->whereYear('obat.created_at', $currentYear)
                ->orderBy('obat.created_at', 'desc')
                ->get();
            // dd($obat);
            return view('cetak.cetak_apoteker_view')->with(compact('obat'));
        }
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
