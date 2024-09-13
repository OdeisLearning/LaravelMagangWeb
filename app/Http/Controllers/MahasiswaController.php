<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $mahasiswa = DB::table('mahasiswa')->where('kelas_id','=',null)->get();
        $kelasDetails = DB::table('kelas')->where('kelas.id','=',$id)->get();
        $kuota_kelas= DB::table('mahasiswa')
                    ->select(DB::raw("count(distinct mahasiswa.id) as count"))
                    ->where('kelas_id','=',$id)
                    ->groupBy('kelas_id')
                    ->get();
        return view('Kaprodi.Kaprodi_DataMahasiswa', ['mahasiswa' => $mahasiswa,'kelasDetails' => $kelasDetails,'kuota_kelas'=>$kuota_kelas]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function formEditMahasiswa(string $id)
    {
        if (Auth::user()->role=='Dosen') {
            $mahasiswa = DB::table('mahasiswa')
                        ->select('mahasiswa.*')
                        ->where('mahasiswa.id','=',$id)
                        ->get();
            return view('mahasiswa.EditDataMahasiswa', ['mahasiswa' => $mahasiswa]);
        }elseif (Auth::user()->role=='Mahasiswa'){
            $mahasiswa=DB::table('mahasiswa')
                        ->select('mahasiswa.*')
                        ->where('mahasiswa.id','=',$id)
                        ->get();
            foreach ($mahasiswa as $key => $value) {
                if ($value->edit==true) {
                    $mahasiswa = DB::table('mahasiswa')
                                ->select('mahasiswa.*')
                                ->where('mahasiswa.id','=',$id)
                                ->get();
                    return view('mahasiswa.EditDataMahasiswa', ['mahasiswa' => $mahasiswa]);
                }else return redirect('Mahasiswa');
            }
        }return response()->json(['Tidak Diijinkan']);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());  //to check all the datas dumped from the form
        //if your want to get single element,someName in this case
        // $someName = $request->someName; 
        $mahasiswa=DB::table('mahasiswa')
                    ->select('mahasiswa.*')
                    ->where('mahasiswa.user_id','=',Auth::id())
                    ->get();
        // dd($mahasiswa);
        foreach ($mahasiswa as $key => $value) {
            if($value->kelas_id!=null){
                $id_kelas=$value->kelas_id;
                $mahasiswa_id=$value->id;
                DB::insert('insert into keterangan (kelas_id,mahasiswa_id, Keterangan) values (?, ?, ?)', [$id_kelas,$mahasiswa_id, $request->Data_Keterangan]);
                return redirect('Mahasiswa');
            }else{
                return redirect('Mahasiswa')->withErrors('Anda Masih Belum Memiliki Kelas');
            }
        }
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $mahasiswa = DB::table('mahasiswa')
                    ->select('mahasiswa.*')
                    ->where('mahasiswa.user_id','=',Auth::id())
                    ->get();
        return view('mahasiswa.DataMahasiswaTable', ['mahasiswa' => $mahasiswa]);
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
        if (Auth::user()->role=='Dosen') {
            DB::update('update mahasiswa set nim = ? where id = ?', [$request->nim,$id]);
            DB::update('update mahasiswa set name = ? where id = ?', [$request->name,$id]);
            DB::update('update mahasiswa set tempat_lahir = ? where id = ?', [$request->tempat_lahir,$id]);
            DB::update('update mahasiswa set tanggal_lahir = ? where id = ?', [$request->tanggal_lahir,$id]);
            return redirect('Data_kelas');
        }elseif (Auth::user()->role=='Mahasiswa'){
            $mahasiswa=DB::table('mahasiswa')
                        ->select('mahasiswa.*')
                        ->where('mahasiswa.id','=',$id)
                        ->get();
            foreach ($mahasiswa as $key => $value) {
                if ($value->edit==true) {
                    DB::update('update mahasiswa set nim = ? where id = ?', [$request->nim,$id]);
                    DB::update('update mahasiswa set name = ? where id = ?', [$request->name,$id]);
                    DB::update('update mahasiswa set tempat_lahir = ? where id = ?', [$request->tempat_lahir,$id]);
                    DB::update('update mahasiswa set tanggal_lahir = ? where id = ?', [$request->tanggal_lahir,$id]);
                    DB::update('update mahasiswa set edit = false where id = ?', [$id]);
                    return redirect('Mahasiswa');
                }else return redirect('Mahasiswa');
            }
        }return response()->json(['Tidak Diijinkan']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
