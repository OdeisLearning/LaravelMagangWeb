<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kelas extends Model
{
    use HasFactory;
    protected $fillable = ['name','jumlah'];

    public function mahasiswa(): HasMany
    {
        return $this->hasMany(Mahasiswa::class, 'kelas_id', 'id');
    }
    public function dosen(): HasOne
    {
        return $this->hasOne(Dosen::class, 'kelas_id', 'id');
    }
}
