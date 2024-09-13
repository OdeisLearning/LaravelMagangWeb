<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa';
    protected $fillable = ['user_id','kelas_id','nim','name','tempat_lahir','tanggal_lahir','edit'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id','id');
    }
}