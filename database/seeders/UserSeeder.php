<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatanMap = Kecamatan::query()->pluck('id', 'nama');

        $users = [
            [
                "username" => "admin123",
                "nama" => "Administrator Sistem",
                "email" => "admin@gmail.com",
                "role" => User::ROLE_ADMIN,
                "kecamatan" => null,
                "nomor_hp" => "0812819281",
                "alamat" => "Indramayu, Jawa Barat",
            ],
            [
                "username" => "operator123",
                "nama" => "Operator Produksi",
                "email" => "operator@gmail.com",
                "role" => User::ROLE_OPERATOR,
                "kecamatan" => null,
                "nomor_hp" => "0812819282",
                "alamat" => "Indramayu, Jawa Barat",
            ],
            [
                "username" => "pimpinan123",
                "nama" => "Pimpinan Dinas",
                "email" => "pimpinan@gmail.com",
                "role" => User::ROLE_PIMPINAN,
                "kecamatan" => null,
                "nomor_hp" => "0812819283",
                "alamat" => "Indramayu, Jawa Barat",
            ],
            [
                "username" => "uptd.haurgeulis",
                "nama" => "Petugas UPTD Haurgeulis",
                "email" => "uptd.haurgeulis@gmail.com",
                "role" => User::ROLE_UPTD,
                "kecamatan" => "Haurgeulis",
                "nomor_hp" => "0812819284",
                "alamat" => "Haurgeulis, Indramayu",
            ],
        ];

        foreach ($users as $user) {
            $kecamatanId = $user["role"] === User::ROLE_UPTD
                ? ($kecamatanMap[$user["kecamatan"]] ?? null)
                : null;

            User::updateOrCreate(
                ["username" => $user["username"]],
                [
                    "nama" => $user["nama"],
                    "email" => $user["email"],
                    "password" => bcrypt("password"),
                    "must_reset_password" => true,
                    "role" => $user["role"],
                    "kecamatan_id" => $kecamatanId,
                    "nomor_hp" => $user["nomor_hp"],
                    "alamat" => $user["alamat"],
                ]
            );
        }
    }
}
