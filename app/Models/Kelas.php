<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $fillable = ['nama', 'guru_id', 'nama_kelas'];

    public function siswaKelas()
    {
        return $this->hasMany(SiswaKelas::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
