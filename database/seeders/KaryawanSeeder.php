<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('karyawans')->insert([
            'nik' => '4321',
            'nama_lengkap' => 'amina',
            'email' => 'aminrizky945@gmail.com',
            'jabatan' => 'IT Asmen',
            'no_hp' => '083119482925',
            'password' => Hash::make('admin123'),
        ]);
    }
}
