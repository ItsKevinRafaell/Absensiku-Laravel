<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'absen';
    protected $fillable = ['siswa_id', 'jam_kedatangan', 'jam_kepulangan', 'date', 'latitude', 'longitude', 'file_kedatangan', 'file_kepulangan', 'latitude_kepulangan', 'longitude_kepulangan', 'keterangan', 'catatan', 'bukti'];
    

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id');
    }
}
