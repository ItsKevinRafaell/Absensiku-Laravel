<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class User extends Model implements Authenticatable
{
    use HasFactory;
    use \Illuminate\Auth\Authenticatable;

    protected $table = 'users';
    protected $fillable = ['nama', 'role_id', 'email', 'password', 'nis', 'nip', 'created_at', 'updated_at', 'alamat', 'no_hp', 'jenis_kelamin'];

    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id', 'id');
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function absen()
    {
        return $this->hasMany(Absen::class, 'siswa_id', 'id');
    }
}
