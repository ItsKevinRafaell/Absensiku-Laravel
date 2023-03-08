<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $fillable = ['nama', 'nis', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function siswaKelas()
    {
        return $this->hasOne(SiswaKelas::class, 'siswa_id', 'id');
    }

    public function absen()
    {
        return $this->hasMany(Absen::class, 'siswa_id', 'id');
    }

    
}
