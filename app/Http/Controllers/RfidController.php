<?php

namespace App\Http\Controllers;

use App\Models\ModelAntrian;
use App\Models\ModelKartu;
use App\Models\ModelPasien;
use App\Models\ModelScanKartu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RfidController extends Controller
{
    public function handleTag(Request $request)
    {
        $tag = $request->query('tag');

        if ($tag) {
            $existingTag = ModelKartu::where('no_kartu', $tag)->first();
            if ($existingTag) {
                return response()->json(['error' => 'ID Sudah Ada']);
            } else {
                ModelKartu::create(['no_kartu' => $tag]);
                return response()->json(['message' => 'Tag stored', 'tag' => $tag]);
            }
        } else {
            return response()->json(['error' => 'Tag is missing']);
        }
    }
    public function antrianTag(Request $request)
    {
        $tag = $request->query('tag');

        if (!$tag) {
            return response()->json(['error' => 'Tag is missing']);
        }

        $pasien = ModelPasien::where('kartu', $tag)->whereNull('deleted_at')->first();


        if ($pasien) {
            // Check if there is an entry for today in the Antrian table

            $antrianExist = ModelAntrian::where('kartu', $tag)
                ->whereDate('updated_at', Carbon::today())
                ->whereNull('deleted_at')
                ->first();

            if (!$antrianExist) {
                $today = Carbon::today();

                $lastNoAntrian = DB::table('antrian')
                    ->whereDate('created_at', $today)
                    ->whereNull('deleted_at')
                    ->orderBy('created_at', 'desc')
                    ->value('no_antrian');


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
                $antrian = new ModelAntrian;
                $antrian->no_antrian = $nextNoAntrian;
                $antrian->kartu = $tag; // Assuming 'kartu' is the column name in the 'Antrian' table
                $antrian->save();
                return response()->json(['success' => $nextNoAntrian]);
            } else {
                return response()->json(['error' => 'Data Sudah Ada']);
            }
        } else {
            return response()->json(['error' => 'Data Tidak Valid']);
        }
    }

    public function index()
    {
        if (Auth::user()->role == 'dokter' || Auth::user()->role == 'apoteker') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akses Ditolak ');
        }
        $kartu = DB::table('kartu')
            ->leftJoin('pasien', 'kartu.id_pasien', '=', 'pasien.id')
            ->select('kartu.*', 'pasien.nik', 'pasien.nama', 'pasien.alamat')
            ->get();

        $scan = DB::table('scan_kartu')
            ->first();



        return view('kartu.kartu_view')->with(compact('kartu', 'scan'));
    }
    public function scan(Request $request)
    {
        if ($request->ajax()) {
            // Update the status in the database
            $status = $request->input('status') === 'ON' ? 1 : 0;
            ModelScanKartu::updateOrCreate([], ['status' => $status]);

            // Get the last status and return it as JSON
            $lastStatus = ModelScanKartu::latest()->value('status');
            return response()->json(['status' => $lastStatus]);
        }

        // If the request is not an AJAX request, return a view or a response accordingly
    }
    public function controlScan()
    {

        $lastStatus = ModelScanKartu::latest()->value('status');
        echo $lastStatus;
    }
}
