<?php

namespace Database\Seeders;

use App\Models\ProduksiMangga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProduksiManggaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // 2021
            ['tahun'=>2021,'triwulan'=>'Q1','luas_tanam'=>100,'luas_panen'=>90,'curah_hujan'=>220,'suhu'=>27,'produksi'=>8],
            ['tahun'=>2021,'triwulan'=>'Q2','luas_tanam'=>110,'luas_panen'=>95,'curah_hujan'=>180,'suhu'=>29,'produksi'=>9],
            ['tahun'=>2021,'triwulan'=>'Q3','luas_tanam'=>120,'luas_panen'=>100,'curah_hujan'=>150,'suhu'=>30,'produksi'=>10],
            ['tahun'=>2021,'triwulan'=>'Q4','luas_tanam'=>130,'luas_panen'=>110,'curah_hujan'=>200,'suhu'=>28,'produksi'=>11],

            // 2022
            ['tahun'=>2022,'triwulan'=>'Q1','luas_tanam'=>140,'luas_panen'=>120,'curah_hujan'=>210,'suhu'=>27,'produksi'=>12],
            ['tahun'=>2022,'triwulan'=>'Q2','luas_tanam'=>150,'luas_panen'=>130,'curah_hujan'=>170,'suhu'=>29,'produksi'=>13],
            ['tahun'=>2022,'triwulan'=>'Q3','luas_tanam'=>160,'luas_panen'=>140,'curah_hujan'=>140,'suhu'=>30,'produksi'=>14],
            ['tahun'=>2022,'triwulan'=>'Q4','luas_tanam'=>170,'luas_panen'=>150,'curah_hujan'=>190,'suhu'=>28,'produksi'=>15],

            // 2023
            ['tahun'=>2023,'triwulan'=>'Q1','luas_tanam'=>180,'luas_panen'=>160,'curah_hujan'=>220,'suhu'=>27,'produksi'=>16],
            ['tahun'=>2023,'triwulan'=>'Q2','luas_tanam'=>190,'luas_panen'=>170,'curah_hujan'=>180,'suhu'=>29,'produksi'=>17],
            ['tahun'=>2023,'triwulan'=>'Q3','luas_tanam'=>200,'luas_panen'=>180,'curah_hujan'=>150,'suhu'=>30,'produksi'=>18],
            ['tahun'=>2023,'triwulan'=>'Q4','luas_tanam'=>210,'luas_panen'=>190,'curah_hujan'=>200,'suhu'=>28,'produksi'=>19],

            // 2024
            ['tahun'=>2024,'triwulan'=>'Q1','luas_tanam'=>220,'luas_panen'=>200,'curah_hujan'=>210,'suhu'=>27,'produksi'=>20],
            ['tahun'=>2024,'triwulan'=>'Q2','luas_tanam'=>230,'luas_panen'=>210,'curah_hujan'=>170,'suhu'=>29,'produksi'=>21],
            ['tahun'=>2024,'triwulan'=>'Q3','luas_tanam'=>240,'luas_panen'=>220,'curah_hujan'=>140,'suhu'=>30,'produksi'=>22],
            ['tahun'=>2024,'triwulan'=>'Q4','luas_tanam'=>250,'luas_panen'=>230,'curah_hujan'=>190,'suhu'=>28,'produksi'=>23],

            // 2025
            ['tahun'=>2025,'triwulan'=>'Q1','luas_tanam'=>260,'luas_panen'=>240,'curah_hujan'=>220,'suhu'=>27,'produksi'=>24],
            ['tahun'=>2025,'triwulan'=>'Q2','luas_tanam'=>270,'luas_panen'=>250,'curah_hujan'=>180,'suhu'=>29,'produksi'=>25],
            ['tahun'=>2025,'triwulan'=>'Q3','luas_tanam'=>280,'luas_panen'=>260,'curah_hujan'=>150,'suhu'=>30,'produksi'=>26],
            ['tahun'=>2025,'triwulan'=>'Q4','luas_tanam'=>290,'luas_panen'=>270,'curah_hujan'=>200,'suhu'=>28,'produksi'=>27],

            // 2026
            ['tahun'=>2026,'triwulan'=>'Q1','luas_tanam'=>300,'luas_panen'=>280,'curah_hujan'=>210,'suhu'=>27,'produksi'=>28],
            ['tahun'=>2026,'triwulan'=>'Q2','luas_tanam'=>310,'luas_panen'=>290,'curah_hujan'=>170,'suhu'=>29,'produksi'=>29],
            ['tahun'=>2026,'triwulan'=>'Q3','luas_tanam'=>320,'luas_panen'=>300,'curah_hujan'=>140,'suhu'=>30,'produksi'=>30],
            ['tahun'=>2026,'triwulan'=>'Q4','luas_tanam'=>330,'luas_panen'=>310,'curah_hujan'=>190,'suhu'=>28,'produksi'=>31],
        ];

        foreach ($data as $item) {
            ProduksiMangga::create($item);
        }
    }
}
