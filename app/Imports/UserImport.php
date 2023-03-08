<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\SiswaKelas;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row[0] == 2) {
            // Create Siswa record
            $user = User::create([
                'role_id' => $row[0],
                'nama' => $row[1],
                'nis' => $row[2],
                'jenis_kelamin' => $row[3],
                'alamat' => $row[4],
                'no_hp' => $row[5],
                'email' => $row[6],
                'password' => bcrypt($row[7]),
            ]);
            $siswa = Siswa::create([
                'user_id' => $user->id,
                'nama' => $user->nama,
            ]);
            SiswaKelas::create([
                'siswa_id' => $siswa->id,
                'kelas_id' => $row[8],
            ]);

        } elseif ($row[0] == 3) {
            // Create Guru record
            $user = User::create([
                'role_id' => $row[0],
                'nama' => $row[1],
                'nip' => $row[2],
                'jenis_kelamin' => $row[3],
                'alamat' => $row[4],
                'no_hp' => $row[5],
                'email' => $row[6],
                'password' => bcrypt($row[7]),
            ]);
            $guru = Guru::create([
                'user_id' => $user->id,
                'nama' => $user->nama,
            ]);
           Kelas::where('nama_kelas', $row[9])
                ->update([
                    'guru_id' => $guru->id,
                ]);
        }
    }
}

