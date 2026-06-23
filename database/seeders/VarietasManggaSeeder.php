<?php

namespace Database\Seeders;

use App\Models\VarietasMangga;
use Illuminate\Database\Seeder;

class VarietasManggaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_varietas' => 'VRT-001',
                'nama_varietas' => 'Gedong Gincu',
                'asal_varietas' => 'Majalengka',
                'deskripsi' => 'Varietas unggulan dengan aroma khas dan warna kulit kemerahan.',
            ],
            [
                'kode_varietas' => 'VRT-002',
                'nama_varietas' => 'Harum Manis',
                'asal_varietas' => 'Probolinggo',
                'deskripsi' => 'Varietas populer dengan rasa manis dan daging buah tebal.',
            ],
            [
                'kode_varietas' => 'VRT-003',
                'nama_varietas' => 'Cengkir',
                'asal_varietas' => 'Indramayu',
                'deskripsi' => 'Varietas lokal yang sering dibudidayakan untuk produktivitas stabil.',
            ],
            [
                'kode_varietas' => 'VRT-004',
                'nama_varietas' => 'Golek',
                'asal_varietas' => 'Pasuruan',
                'deskripsi' => 'Varietas dengan bentuk lonjong dan daya simpan yang baik.',
            ],
            [
                'kode_varietas' => 'VRT-005',
                'nama_varietas' => 'Manalagi',
                'asal_varietas' => 'Situbondo',
                'deskripsi' => 'Varietas dengan tekstur padat dan cita rasa manis segar.',
            ],
        ];

        foreach ($data as $item) {
            VarietasMangga::updateOrCreate(
                ['kode_varietas' => $item['kode_varietas']],
                $item
            );
        }
    }
}
