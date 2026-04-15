<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "username" => "admin123",
            "nama" => "Administrator",
            "email" => "admin@gmail.com",
            "password" => bcrypt("password"),
            "nomor_hp" => "0812819281",
            "alamat" => "Jakarta Raya, Indonesia"
        ]);
    }
}
