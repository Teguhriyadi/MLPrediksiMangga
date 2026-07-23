<?php

namespace Database\Seeders;

use App\Models\ProduksiMangga;
use App\Models\VarietasMangga;
use Illuminate\Database\Seeder;

class ProduksiManggaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $varietasMap = VarietasMangga::query()
            ->pluck('id', 'nama_varietas');

        $kecamatanProfiles = [
            ['kecamatan' => 'Haurgeulis', 'varietas' => 'Gedong Gincu', 'base_produksi' => 20.4, 'base_luas_tanam' => 74, 'base_pohon' => 275619],
            ['kecamatan' => 'Gantar', 'varietas' => 'Cengkir', 'base_produksi' => 7.1, 'base_luas_tanam' => 31, 'base_pohon' => 90250],
            ['kecamatan' => 'Kroya', 'varietas' => 'Harum Manis', 'base_produksi' => 16.3, 'base_luas_tanam' => 58, 'base_pohon' => 205960],
            ['kecamatan' => 'Gabuswetan', 'varietas' => 'Cengkir', 'base_produksi' => 2.8, 'base_luas_tanam' => 11, 'base_pohon' => 24000],
            ['kecamatan' => 'Cikedung', 'varietas' => 'Gedong Gincu', 'base_produksi' => 18.6, 'base_luas_tanam' => 65, 'base_pohon' => 284064],
            ['kecamatan' => 'Terisi', 'varietas' => 'Golek', 'base_produksi' => 17.5, 'base_luas_tanam' => 62, 'base_pohon' => 28040],
            ['kecamatan' => 'Lelea', 'varietas' => 'Gedong Gincu', 'base_produksi' => 5.2, 'base_luas_tanam' => 20, 'base_pohon' => 100600],
            ['kecamatan' => 'Bangodua', 'varietas' => 'Cengkir', 'base_produksi' => 11.8, 'base_luas_tanam' => 41, 'base_pohon' => 61524],
            ['kecamatan' => 'Tukdana', 'varietas' => 'Harum Manis', 'base_produksi' => 9.7, 'base_luas_tanam' => 35, 'base_pohon' => 153582],
            ['kecamatan' => 'Widasari', 'varietas' => 'Gedong Gincu', 'base_produksi' => 10.8, 'base_luas_tanam' => 36, 'base_pohon' => 62840],
            ['kecamatan' => 'Kertasemaya', 'varietas' => 'Manalagi', 'base_produksi' => 4.4, 'base_luas_tanam' => 18, 'base_pohon' => 38064],
            ['kecamatan' => 'Sukagumiwang', 'varietas' => 'Golek', 'base_produksi' => 12.5, 'base_luas_tanam' => 42, 'base_pohon' => 72316],
            ['kecamatan' => 'Krangkeng', 'varietas' => 'Gedong Gincu', 'base_produksi' => 13.2, 'base_luas_tanam' => 46, 'base_pohon' => 107714],
            ['kecamatan' => 'Karangampel', 'varietas' => 'Harum Manis', 'base_produksi' => 6.1, 'base_luas_tanam' => 23, 'base_pohon' => 17866],
            ['kecamatan' => 'Kedokan Bunder', 'varietas' => 'Cengkir', 'base_produksi' => 8.6, 'base_luas_tanam' => 29, 'base_pohon' => 62140],
            ['kecamatan' => 'Juntinyuat', 'varietas' => 'Gedong Gincu', 'base_produksi' => 14.7, 'base_luas_tanam' => 50, 'base_pohon' => 165320],
            ['kecamatan' => 'Sliyeg', 'varietas' => 'Manalagi', 'base_produksi' => 19.3, 'base_luas_tanam' => 68, 'base_pohon' => 153920],
            ['kecamatan' => 'Jatibarang', 'varietas' => 'Gedong Gincu', 'base_produksi' => 22.8, 'base_luas_tanam' => 79, 'base_pohon' => 299380],
            ['kecamatan' => 'Balongan', 'varietas' => 'Harum Manis', 'base_produksi' => 6.9, 'base_luas_tanam' => 24, 'base_pohon' => 66460],
            ['kecamatan' => 'Indramayu', 'varietas' => 'Gedong Gincu', 'base_produksi' => 2.5, 'base_luas_tanam' => 9, 'base_pohon' => 15220],
            ['kecamatan' => 'Sindang', 'varietas' => 'Cengkir', 'base_produksi' => 5.6, 'base_luas_tanam' => 21, 'base_pohon' => 54125],
            ['kecamatan' => 'Cantigi', 'varietas' => 'Gedong Gincu', 'base_produksi' => 15.6, 'base_luas_tanam' => 54, 'base_pohon' => 107244],
            ['kecamatan' => 'Pasekan', 'varietas' => 'Manalagi', 'base_produksi' => 3.6, 'base_luas_tanam' => 14, 'base_pohon' => 18840],
            ['kecamatan' => 'Lohbener', 'varietas' => 'Gedong Gincu', 'base_produksi' => 10.5, 'base_luas_tanam' => 37, 'base_pohon' => 79834],
            ['kecamatan' => 'Arahan', 'varietas' => 'Golek', 'base_produksi' => 8.9, 'base_luas_tanam' => 31, 'base_pohon' => 70073],
            ['kecamatan' => 'Losarang', 'varietas' => 'Cengkir', 'base_produksi' => 9.4, 'base_luas_tanam' => 33, 'base_pohon' => 70518],
            ['kecamatan' => 'Kandanghaur', 'varietas' => 'Harum Manis', 'base_produksi' => 4.1, 'base_luas_tanam' => 15, 'base_pohon' => 17240],
            ['kecamatan' => 'Bongas', 'varietas' => 'Gedong Gincu', 'base_produksi' => 4.6, 'base_luas_tanam' => 17, 'base_pohon' => 17940],
            ['kecamatan' => 'Anjatan', 'varietas' => 'Gedong Gincu', 'base_produksi' => 12.8, 'base_luas_tanam' => 45, 'base_pohon' => 107312],
            ['kecamatan' => 'Sukra', 'varietas' => 'Manalagi', 'base_produksi' => 2.9, 'base_luas_tanam' => 10, 'base_pohon' => 11817],
            ['kecamatan' => 'Patrol', 'varietas' => 'Cengkir', 'base_produksi' => 1.8, 'base_luas_tanam' => 7, 'base_pohon' => 4780],
        ];

        foreach ($kecamatanProfiles as $indexKecamatan => $profile) {
            $varietasId = $varietasMap[$profile['varietas']] ?? $varietasMap->first();

            for ($tahun = 2021; $tahun <= 2026; $tahun++) {
                foreach (['Q1', 'Q2', 'Q3', 'Q4'] as $indexTriwulan) {
                    $seasonalFactor = match ($indexTriwulan) {
                        'Q1' => 1.08,
                        'Q2' => 1.02,
                        'Q3' => 0.95,
                        default => 1.05,
                    };

                    $yearFactor = 1 + (($tahun - 2021) * 0.035);
                    $regionalFactor = 1 + (($indexKecamatan % 5) * 0.018);
                    $produksi = round($profile['base_produksi'] * $seasonalFactor * $yearFactor * $regionalFactor, 2);
                    $luasTanam = round($profile['base_luas_tanam'] * $regionalFactor * (1 + (($tahun - 2021) * 0.015)), 2);
                    $luasPanen = round($luasTanam * (0.86 + (($indexKecamatan % 4) * 0.015)), 2);
                    $jumlahPohon = (int) round($profile['base_pohon'] * $regionalFactor * (1 + (($tahun - 2021) * 0.012)));

                    ProduksiMangga::query()->updateOrCreate(
                        [
                            'kecamatan' => $profile['kecamatan'],
                            'tahun' => $tahun,
                            'triwulan' => $indexTriwulan,
                        ],
                        [
                            'varietas_mangga_id' => $varietasId,
                            'luas_tanam' => $luasTanam,
                            'luas_panen' => $luasPanen,
                            'jumlah_pohon' => $jumlahPohon,
                            'umur_tanaman' => 5 + (($tahun + $indexKecamatan) % 7),
                            'produksi' => $produksi,
                            'catatan' => 'Data contoh multi-kecamatan untuk simulasi analisis dan prediksi produktivitas mangga berbasis SARIMA.',
                        ]
                    );
                }
            }
        }
    }
}
