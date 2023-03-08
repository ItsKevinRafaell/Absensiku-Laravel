<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\SiswaKelas;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class UserTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        DB::table('roles')->insert([
            ['role' => 'admin'],
            ['role' => 'student'],
            ['role' => 'teacher'],
        ]);
            
            User::create([
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',    
                'password' => bcrypt('password'),
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            User::create([
                'nama' => 'Kevin',
                'nis' => 1,
                'email' => 'kevin@gmail.com',
                'password' => bcrypt('password'),
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            User::create([
                'nama' => 'Bu Etik',
                'nip' => 1,
                'email' => 'etik@gmail.com',
                'password' => bcrypt('password'),
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            
            $users = DB::table('users')->get();
            foreach ($users as $user) {
                if ($user->role_id == 1) {
                    $admin =  DB::table('admin')->insert([
                        'user_id' => $user->id,
                        'nama' => $user->nama,
                        'nip' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else if ($user->role_id == 2) {
                    $siswa = DB::table('siswa')->insert([
                        'user_id' => $user->id,
                        'nama' => $user->nama,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else if ($user->role_id == 3) {
                    $guru = DB::table('guru')->insert([
                        'user_id' => $user->id,
                        'nama' => $user->nama,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
            
            $guru = Guru::first();
            
            // $kelas = new Kelas();
            // $kelas->guru_id = $guru->id;
            // $kelas->nama_kelas = 'RPL';
            // $kelas->save();

            $kelas =  Kelas::create([
                'guru_id' => $guru->id,
                'nama_kelas' => 'RPL',
            ]);

            Kelas::create([
                'nama_kelas' => 'TKJ',
            ]);
            
            Kelas::create([
                'nama_kelas' => 'GP',
            ]);
            
            Kelas::create([
                'nama_kelas' => 'TAB',
            ]);
            
            Kelas::create([
                'nama_kelas' => 'TAV',
            ]);
            
            Kelas::create([
                'nama_kelas' => 'GEOM',
            ]);
            
            $murid_kelas = SiswaKelas::create([
                'siswa_id' => 1,
                'kelas_id' => $kelas->id,
            ]);
        }
    }
    