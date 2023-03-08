<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guru = Guru::first();

        $kelas = new Kelas();
        $kelas->guru_id = $guru->id;
        $kelas->nama_kelas = 'RPL';
        $kelas->save();
    }
}
