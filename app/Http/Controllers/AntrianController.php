<?php

namespace App\Http\Controllers;

use App\Models\ModelAntrian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AntrianController extends Controller
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
        if (Auth::user()->role == 'dokter' || Auth::user()->role == 'apoteker') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akses Ditolak ');
        }
        $antrian = DB::table('antrian')
            ->select('antrian.*', 'pasien.id as pasien_id', 'pasien.nik', 'pasien.nama', 'pasien.alamat') // Select all columns from both tables
            ->join('pasien', 'antrian.kartu', '=', 'pasien.kartu') // Join based on the foreign key relationship
            ->whereNull('antrian.deleted_at')
            ->whereNull('pasien.deleted_at')
            ->whereDate('antrian.created_at', now()->toDateString())
            ->whereNotIn('antrian.id', function ($query) {
                $query->select('pelayanan.antrian_id')->from('pelayanan');
            })
            ->orderBy('antrian.created_at', 'asc')
            ->get();

        // dd($antrian);
        return view('antrian.antrian_view')->with(compact('antrian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pasien = DB::table('pasien')
            ->select('*')
            ->whereNull('pasien.deleted_at') // Filter for today's date in the 'pasien' table
            ->orderBy('nama', 'desc')
            ->get();

        // Get the current date
        $today = Carbon::today();

        // Get the last 'no_antrian' for today
        $lastNoAntrian = DB::table('antrian')
            ->whereDate('created_at', $today)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->value('no_antrian');

            
        // Generate the next 'no_antrian'
        if ($lastNoAntrian === null) {
            $nextNoAntrian = 'A001'; // If no 'no_antrian' exists for today, start from 'A001'
        } else {
            $prefix = substr($lastNoAntrian, 0, 1);
            $number = (int)substr($lastNoAntrian, 1);
            if ($number == 999) {
                $nextNoAntrian = $prefix . '001'; // Reset to '001' if the number reaches 999
            } else {
                $nextNoAntrian = $prefix . str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment the number
            }
        }
        return view('antrian.antrian_create_view')->with(compact('pasien', 'nextNoAntrian'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_antrian' => ['required', 'string', 'max:4'],
            'nik' => ['required', 'string', 'max:16'],
            'nama' => ['required', 'string', 'max:255'],
            'kartu' => ['required', 'string', 'max:50'],
            'alamat' => ['required', 'string', 'max:255'],
        ]);

        ModelAntrian::create([
            'no_antrian' => $validatedData['no_antrian'],
            'kartu' => $validatedData['kartu'],
        ]);
        return redirect()->route('antrian.index')
            ->with('success', 'Berhasil Menambahkan Antrian Pasien');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pasien =  DB::table('pasien')
            ->select('*')
            ->where('id', '=', $id)
            ->get();

        return response()->json(['pasien' => $pasien]);
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
        $modelAntrian = ModelAntrian::find($id);
        if ($modelAntrian) {
            $modelAntrian->delete();
        }
    }
}
