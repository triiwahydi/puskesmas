<?php

namespace App\Http\Controllers;

use App\Models\ModelLiveAntrian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LiveAntrianController extends Controller
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

        $today = Carbon::now()->format('Y-m-d');

        $nextNoAntrian = ModelLiveAntrian::whereDate('updated_at', '=', $today)
            ->orderBy('updated_at', 'desc')
            ->first();

        // Generate the next 'no_antrian'
        if ($nextNoAntrian === null) {
            $nextNoAntrian = '-'; // If no 'no_antrian' exists for today, start from 'A001'
        }

        return view('antrian.antrian_live_view')->with(compact('nextNoAntrian'));
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
        $nextNoAntrian = ModelLiveAntrian::whereDate('updated_at', now()->toDateString())
        ->latest()
        ->first();

        // Return the last record as a JSON response
        return response()->json($nextNoAntrian);
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
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'no_antrian' => 'required|string',
            'nama' => 'required|string',
            'alamat' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Check if any records exist in the table
        $recordCount = ModelLiveAntrian::count();

        if ($recordCount == 0) {
            // No records exist, create a new record
            ModelLiveAntrian::create([
                'no_antrian' => $request->input('no_antrian'),
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
            ]);
        } else {
            // Records exist, get the last record's ID
            $lastRecord = ModelLiveAntrian::latest()->first();

            // Update the last record with the new data
            $lastRecord->update([
                'no_antrian' => $request->input('no_antrian'),
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
            ]);
        }
        $record = ModelLiveAntrian::latest()->first();

        // Optionally, you can return a response indicating success
        return response()->json(['message' => 'success', 'data' => $record]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
