<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','kelas_id','kode_dosen','nip','name'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id','id');
    }
}
