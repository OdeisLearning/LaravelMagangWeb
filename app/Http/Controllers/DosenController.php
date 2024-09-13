<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dosen = Dosen::all();
        return view('Kaprodi.Kaprodi_DataDosen')
            ->with('Kaprodi', $dosen);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function decline(string $id)
    {
        DB::table('keterangan')->delete($id);
        return redirect('Data_kelas');
    }

    public function approve(string $id)
    {
        $keterangan= DB::table('keterangan')
                    ->leftJoin('mahasiswa','keterangan.mahasiswa_id','mahasiswa.id')
                    ->where('keterangan.id','=',$id)
                    ->get();
        foreach ($keterangan as $key => $value) {
            DB::update('update mahasiswa set edit = true where id = ?', [$value->mahasiswa_id]);
            DB::table('keterangan')->delete($id);
        }
        return redirect('Data_kelas');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //passing user to view
        $Dosen = DB::table('dosens')
                    ->where('kelas_id',$id);
        $kelas = Kelas::find($id);
        $dosenTable = DB::table('dosens')->where('kelas_id','=',null)->get();

        return view('Kaprodi.Kaprodi_ReplaceDosenWali', ['kelas' => $kelas,'dosedetail'=>$dosenTable,'Dosen'=>$Dosen]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id,string $kId)
    {
        
        $Dosen = DB::update('update dosens set kelas_id = null where kelas_id = ?', [$kId]);
        $Dosen = DB::update('update dosens set kelas_id = ? where id = ?', [$kId,$id]);
        
        //passing user to view
        $kelas= Kelas::find($kId)->mahasiswa()
                    ->where('kelas_id',$kId)
                    ->get();

        $kelasDetails = DB::table('kelas')
                    ->leftJoin('dosens', 'kelas.id', '=', 'dosens.kelas_id')
                    ->leftJoin('mahasiswa', 'kelas.id', '=', 'mahasiswa.kelas_id')
                    ->select('kelas.*', 'dosens.name as dname','mahasiswa.id as mid','mahasiswa.nim','mahasiswa.name as maname','mahasiswa.tanggal_lahir','mahasiswa.tempat_lahir')
                    ->where('kelas.id','=',$kId,'and','dosen.kelas_id','=',$kId,'and','mahasiswa.kelas_id','=',$kId)
                    ->get();
        $kuota_kelas= DB::table('mahasiswa')
                    ->leftJoin('kelas','mahasiswa.kelas_id','=','kelas.id')
                    ->select('kelas.jumlah','kelas_id',DB::raw("count(distinct mahasiswa.id) as count"))
                    ->where('kelas_id','=',$kId)
                    ->groupBy('kelas_id')
                    ->get();    
        //$dosen=Dosen::where('kelas_id', $id)->get();
        $dosen= DB::table('dosens')
                    ->select('dosens.*')
                    ->where('dosens.kelas_id','=',$kId)
                    ->get();

        return view('Kaprodi.Kaprodi_viewKelas', ['kelasDetails' => $kelasDetails,'dosedetail'=>$dosen,'kuota_kelas'=>$kuota_kelas,'kelas'=>$kelas]);
    }
}
