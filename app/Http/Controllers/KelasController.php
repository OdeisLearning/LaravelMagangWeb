<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $kelas = Kelas::latest()->get();
        // return view('Kaprodi.Kaprodi_DataKelas', compact('kelas'));

        // // load the view and pass the sharks
        // return view('Kaprodi.Kaprodi_DataKelas')
        //     ->with('Kaprodi', $kelas);//

        // //get users form Model
        // $users = User::latest()->get();

        //passing user to view
        $kelasDetails = DB::table('kelas')
                    ->leftJoin('dosens', 'kelas.id', '=', 'dosens.kelas_id')
                    ->leftJoin('mahasiswa', 'kelas.id', '=', 'mahasiswa.kelas_id')
                    ->select('kelas.*', 'dosens.kode_dosen', 'dosens.name as dname',DB::raw("count(distinct mahasiswa.id) as count"))
                    ->groupBy('kelas.id','dosens.kode_dosen')
                    ->get();

        return view('Kaprodi.Kaprodi_DataKelas', ['kelasDetails' => $kelasDetails]);
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
        //passing user to view
        $kelas= Kelas::find($id)->mahasiswa()
                    ->where('kelas_id',$id)
                    ->get();

        $kelasDetails = DB::table('kelas')
                    ->leftJoin('dosens', 'kelas.id', '=', 'dosens.kelas_id')
                    ->leftJoin('mahasiswa', 'kelas.id', '=', 'mahasiswa.kelas_id')
                    ->select('kelas.*', 'dosens.name as dname','mahasiswa.id as mid','mahasiswa.nim','mahasiswa.name as maname','mahasiswa.tanggal_lahir','mahasiswa.tempat_lahir')
                    ->where('kelas.id','=',$id,'and','dosen.kelas_id','=',$id,'and','mahasiswa.kelas_id','=',$id)
                    ->get();
        $kuota_kelas= DB::table('mahasiswa')
                    ->leftJoin('kelas','mahasiswa.kelas_id','=','kelas.id')
                    ->select('kelas.jumlah','kelas_id',DB::raw("count(distinct mahasiswa.id) as count"))
                    ->where('kelas_id','=',$id)
                    ->groupBy('kelas_id')
                    ->get();    
        //$dosen=Dosen::where('kelas_id', $id)->get();
        $dosen= DB::table('dosens')
                    ->select('dosens.*')
                    ->where('dosens.kelas_id','=',$id)
                    ->get();

        return view('Kaprodi.Kaprodi_viewKelas', ['kelasDetails' => $kelasDetails,'dosedetail'=>$dosen,'kuota_kelas'=>$kuota_kelas,'kelas'=>$kelas]);
    }

    /**
     * Display the specified resource.
     */

    public function dataKelas()
    {
        //passing user to view
        $dosen= DB::table('dosens')
                    ->select('dosens.*')
                    ->where('dosens.user_id','=',Auth::id())
                    ->get();
        foreach ($dosen as $key => $value) {
            $kelasDetails = DB::table('kelas')
                    ->leftJoin('dosens', 'kelas.id', '=', 'dosens.kelas_id')
                    ->leftJoin('mahasiswa', 'kelas.id', '=', 'mahasiswa.kelas_id')
                    ->select('kelas.*', 'dosens.name as dname','mahasiswa.id as mid','mahasiswa.nim','mahasiswa.name as maname','mahasiswa.tanggal_lahir','mahasiswa.tempat_lahir')
                    ->where('kelas.id','=',$value->kelas_id,'and','dosen.kelas_id','=',$value->kelas_id,'and','mahasiswa.kelas_id','=',$value->kelas_id)
                    ->get();
            $kuota_kelas= DB::table('mahasiswa')
                    ->leftJoin('kelas','mahasiswa.kelas_id','=','kelas.id')
                    ->select('kelas.jumlah','kelas_id',DB::raw("count(distinct mahasiswa.id) as count"))
                    ->where('kelas_id','=',$value->kelas_id)
                    ->groupBy('kelas_id')
                    ->get();
            $keterangan = DB::table('keterangan')
                    ->leftJoin('mahasiswa','keterangan.mahasiswa_id','=','mahasiswa.id')
                    ->select('keterangan.*','mahasiswa.id as mid','mahasiswa.name','mahasiswa.nim','mahasiswa.kelas_id')
                    ->where('keterangan.kelas_id','=',$value->kelas_id)
                    ->get();
            return view('Dosen.Data_kelas', ['kelasDetails' => $kelasDetails,'dosedetail'=>$dosen,'kuota_kelas'=>$kuota_kelas,'keterangan'=>$keterangan]);
        }
        

        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id,string $mid)
    {
        // DB::update('update mahasiswa set kelas_id = ? where id = ?', [$id,$mid]);
        $Mahasiswa = Mahasiswa::find($mid);
        $Mahasiswa->kelas_id = $id;
        $Mahasiswa->save();
        $Mahasiswa = DB::update('update mahasiswa set kelas_id = ? where id = ?', [$id,$mid]);
        //passing user to view
        $kelas= Kelas::find($id)->mahasiswa()
                    ->where('kelas_id',$id)
                    ->get();

        $kelasDetails = DB::table('kelas')
                    ->leftJoin('dosens', 'kelas.id', '=', 'dosens.kelas_id')
                    ->leftJoin('mahasiswa', 'kelas.id', '=', 'mahasiswa.kelas_id')
                    ->select('kelas.*', 'dosens.name as dname','mahasiswa.id as mid','mahasiswa.nim','mahasiswa.name as maname','mahasiswa.tanggal_lahir','mahasiswa.tempat_lahir')
                    ->where('kelas.id','=',$id,'and','dosen.kelas_id','=',$id,'and','mahasiswa.kelas_id','=',$id)
                    ->get();
        $kuota_kelas= DB::table('mahasiswa')
                    ->leftJoin('kelas','mahasiswa.kelas_id','=','kelas.id')
                    ->select('kelas.jumlah','kelas_id',DB::raw("count(distinct mahasiswa.id) as count"))
                    ->where('kelas_id','=',$id)
                    ->groupBy('kelas_id')
                    ->get();    
        //$dosen=Dosen::where('kelas_id', $id)->get();
        $dosen= DB::table('dosens')
                    ->select('dosens.*')
                    ->where('dosens.kelas_id','=',$id)
                    ->get();

        return view('Kaprodi.Kaprodi_viewKelas', ['kelasDetails' => $kelasDetails,'dosedetail'=>$dosen,'kuota_kelas'=>$kuota_kelas,'kelas'=>$kelas]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Mahasiswa= Mahasiswa::find($id);
        $kelas_id=$Mahasiswa->kelas_id;
        DB::update('update mahasiswa set kelas_id = null where id = ?', [$id]);
        $kelasDetails = DB::table('kelas')
                    ->leftJoin('dosens', 'kelas.id', '=', 'dosens.kelas_id')
                    ->leftJoin('mahasiswa', 'kelas.id', '=', 'mahasiswa.kelas_id')
                    ->select('kelas.*', 'dosens.kode_dosen', 'dosens.name as dname',DB::raw("count(distinct mahasiswa.id) as count"))
                    ->groupBy('kelas.id','dosens.kode_dosen')
                    ->get();

        //passing user to view
        $kelas= Kelas::find($kelas_id)->mahasiswa()
                    ->where('kelas_id',$kelas_id)
                    ->get();

        $kelasDetails = DB::table('kelas')
                    ->leftJoin('dosens', 'kelas.id', '=', 'dosens.kelas_id')
                    ->leftJoin('mahasiswa', 'kelas.id', '=', 'mahasiswa.kelas_id')
                    ->select('kelas.*', 'dosens.name as dname','mahasiswa.id as mid','mahasiswa.nim','mahasiswa.name as maname','mahasiswa.tanggal_lahir','mahasiswa.tempat_lahir')
                    ->where('kelas.id','=',$kelas_id,'and','dosen.kelas_id','=',$kelas_id,'and','mahasiswa.kelas_id','=',$kelas_id)
                    ->get();
        $kuota_kelas= DB::table('mahasiswa')
                    ->leftJoin('kelas','mahasiswa.kelas_id','=','kelas.id')
                    ->select('kelas.jumlah','kelas_id',DB::raw("count(distinct mahasiswa.id) as count"))
                    ->where('kelas_id','=',$kelas_id)
                    ->groupBy('kelas_id')
                    ->get();    
        //$dosen=Dosen::where('kelas_id', $id)->get();
        $dosen= DB::table('dosens')
                    ->select('dosens.*')
                    ->where('dosens.kelas_id','=',$kelas_id)
                    ->get();

        return view('Kaprodi.Kaprodi_viewKelas', ['kelasDetails' => $kelasDetails,'dosedetail'=>$dosen,'kuota_kelas'=>$kuota_kelas,'kelas'=>$kelas]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
