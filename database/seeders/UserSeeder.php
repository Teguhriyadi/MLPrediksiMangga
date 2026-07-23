<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "username" => "admin123",
                "nama" => "Administrator Sistem",
                "email" => "admin@gmail.com",
                "role" => User::ROLE_ADMIN,
                "nomor_hp" => "0812819281",
                "alamat" => "Indramayu, Jawa Barat",
            ],
            [
                "username" => "operator123",
                "nama" => "Operator Produksi",
                "email" => "operator@gmail.com",
                "role" => User::ROLE_OPERATOR,
                "nomor_hp" => "0812819282",
                "alamat" => "Indramayu, Jawa Barat",
            ],
            [
                "username" => "pimpinan123",
                "nama" => "Pimpinan Dinas",
                "email" => "pimpinan@gmail.com",
                "role" => User::ROLE_PIMPINAN,
                "nomor_hp" => "0812819283",
                "alamat" => "Indramayu, Jawa Barat",
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ["username" => $user["username"]],
                [
                    "nama" => $user["nama"],
                    "email" => $user["email"],
                    "password" => bcrypt("password"),
                    "must_reset_password" => true,
                    "role" => $user["role"],
                    "nomor_hp" => $user["nomor_hp"],
                    "alamat" => $user["alamat"],
                ]
            );
        }
    }
}
