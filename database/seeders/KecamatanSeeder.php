<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Haurgeulis',
            'Gantar',
            'Kroya',
            'Gabuswetan',
            'Cikedung',
            'Terisi',
            'Lelea',
            'Bangodua',
            'Tukdana',
            'Widasari',
            'Kertasemaya',
            'Sukagumiwang',
            'Krangkeng',
            'Karangampel',
            'Kedokan Bunder',
            'Juntinyuat',
            'Sliyeg',
            'Jatibarang',
            'Balongan',
            'Indramayu',
            'Sindang',
            'Cantigi',
            'Pasekan',
            'Lohbener',
            'Arahan',
            'Losarang',
            'Kandanghaur',
            'Bongas',
            'Anjatan',
            'Sukra',
            'Patrol',
        ];

        foreach ($names as $name) {
            Kecamatan::query()->updateOrCreate(
                ['nama' => $name],
                ['is_active' => true]
            );
        }
    }
}
