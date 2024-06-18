<?php

namespace App\Http\Controllers;

use App\Models\ModelKartu;
use App\Models\ModelPasien;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PasienController extends Controller
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
        $pasien = DB::table('pasien')
            ->select('*')
            ->whereNull('deleted_at')
            ->orderBy('nama', 'asc')
            ->get();

        // dd($pasien);
        return view('pasien.pasien_view')->with(compact('pasien'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kartu = ModelKartu::all(); // Retrieve all data from the kartu table

        // Fetch the nama from pasien table based on id_pasien
        foreach ($kartu as $item) {
            if ($item->id_pasien === null) {
                $item->nama = 'Belum Dipakai';
            } else {
                $pasien = ModelPasien::find($item->id_pasien);
                $item->nama = $pasien ? $pasien->nama : 'Belum Dipakai';
            }
        }

        if ($kartu->isNotEmpty()) {
            return view('pasien.pasien_create_view', compact('kartu'));
        } else {
            // Handle the case where no data exists in the kartu table
            return view('pasien.pasien_create_view');
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'nik' => ['required', 'string', 'max:16', Rule::unique('pasien', 'nik')->whereNull('deleted_at')],
            'bpjs' => ['required', 'string', 'max:50', Rule::unique('pasien', 'bpjs')->whereNull('deleted_at')],
            'nama' => ['required', 'string', 'max:255'],
            'tgl_lahir' => ['required', 'string', 'max:10'],
            'jen_kel' => ['required', 'string', 'max:50'],
            'umur' => ['required', 'string', 'max:100'],
            'hp' => ['nullable', 'string', 'max:16'],
            'kartu' => ['required', 'string', 'max:50', Rule::unique('pasien', 'kartu')->whereNull('deleted_at')],
            'alamat' => ['required', 'string', 'max:255'],

        ]);

        $validatedData['nama'] = Str::ucfirst($validatedData['nama']);
        $validatedData['alamat'] = Str::ucfirst($validatedData['alamat']);
        // store to database
        $createdPasien = ModelPasien::create($validatedData);
        $id = $createdPasien->id;

        ModelKartu::where('id_pasien',  $id)
         ->update(['status' => 0, 'id_pasien' => NULL]);
        ModelKartu::where('no_kartu', $validatedData['kartu'])
         ->update(['status' => 1, 'id_pasien' => $id]);
        return redirect()->route('pasien.index')
            ->with('success', 'Berhasil Mendaftarkan Pasien');
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
        $pasien =  DB::table('pasien')
            ->select('*')
            ->where('id', '=', $id)
            ->get();

        $kartu = DB::table('kartu')
            ->get();

        foreach ($kartu as $item) {
            if ($item->id_pasien === null) {
                $item->nama = 'Belum Dipakai';
            } else {
                $datapasien = DB::table('pasien')
                    ->select('nama')
                    ->where('id', '=', $item->id_pasien)
                    ->first();
                $item->nama = $datapasien ? $datapasien->nama : 'Belum Dipakai';
            }
        }

        
        return view('pasien.pasien_edit_view')->with(compact('pasien','kartu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nik' => ['required', 'string', 'max:16'],
            'bpjs' => ['required', 'string', 'max:50'],
            'nama' => ['required', 'string', 'max:255'],
            'tgl_lahir' => ['required', 'string', 'max:10'],
            'jen_kel' => ['required', 'string', 'max:50'],
            'umur' => ['required', 'string', 'max:100'],
            'hp' => ['nullable', 'string', 'max:16'],
            'kartu' => ['required', 'string', 'max:50'],
            'alamat' => ['required', 'string', 'max:255'],

        ]);


     // Get the current 'kartu' value from the database
    $currentKartu = ModelPasien::find($id)->kartu;
    
    // Update the patient's data
    ModelPasien::where('id', $id)->update($validatedData);
    
    // Check if 'kartu' has changed
    if ($validatedData['kartu'] !== $currentKartu) {
        ModelKartu::where('id_pasien', $id)->update(['status' => 0, 'id_pasien' => NULL]);
        ModelKartu::where('no_kartu', $validatedData['kartu'])->update(['status' => 1, 'id_pasien' => $id]);
    }
        
        return redirect()->route('pasien.index')
            ->with('success', 'Berhasil Update Data Pasien');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $modelPasien = ModelPasien::find($id);
        if ($modelPasien) {
            $modelPasien->delete();
        }
    }
}
