<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class isiKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelasDetails = DB::table('kelas')
                    ->leftJoin('dosens', 'kelas.id', '=', 'dosens.kelas_id')
                    ->leftJoin('mahasiswa', 'kelas.id', '=', 'mahasiswa.kelas_id')
                    ->select('kelas.id', 'dosens.kode_dosen', 'dosens.name as dname','mahasiswa.nim','mahasiswa.name as maname',"mahasiswa.tempat_lahir",'mahasiswa.tanggal_lahir',DB::raw("count(distinct mahasiswa.id) as count"))
                    ->groupBy('kelas.id','dosens.kode_dosen')
                    ->get();

         // Fetch user details
         $kelas = Kelas::all();

         // Fetch user details
         $dosen = Dosen::all();

         // Fetch contact details
         $mahasiswa = Mahasiswa::all();

        return view('Kaprodi.Kaprodi_DataKelas', ['kelasDetails' => $kelasDetails, 'dosendata' => $dosen, 'mahadata' => $mahasiswa, 'keldata' => $kelas]);
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
