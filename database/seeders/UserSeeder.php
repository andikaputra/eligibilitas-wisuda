<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('password123'),
                'prodi' =>'Pendidikan Guru Sekolah Dasar',
                'role' => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Perpustakaan',
                'username' => 'adminperpus',
                'password' => Hash::make('password123'),
                'prodi' =>'Pendidikan Guru Sekolah Dasar',
                'role' => 'admin_perpus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mahasiswa Contoh',
                'username' => 'mahasiswa1',
                'password' => Hash::make('password123'),
                'prodi' =>'Pendidikan Guru Sekolah Dasar',
                'role' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bendahara',
                'username' => 'bendahara',
                'password' => Hash::make('password123'),
                'prodi' =>'Pendidikan Guru Sekolah Dasar',
                'role' => 'bendahara',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
