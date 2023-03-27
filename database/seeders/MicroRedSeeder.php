<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MicroRed;
class MicroRedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $microred1 = MicroRed::firstOrCreate(['nombre' => 'YARUMAYO', 'red_id' => 1]);
        $microred2 = MicroRed::firstOrCreate(['nombre' => 'YACUS', 'red_id' => 1]);
        $microred3 = MicroRed::firstOrCreate(['nombre' => 'UMARI', 'red_id' => 3]);
        $microred4 = MicroRed::firstOrCreate(['nombre' => 'TOMAYKICHWA', 'red_id' => 2]);
        $microred5 = MicroRed::firstOrCreate(['nombre' => 'SANTA MARIA DEL VALLE', 'red_id' => 1]);
        $microred6 = MicroRed::firstOrCreate(['nombre' => 'SAN RAFAEL', 'red_id' => 2]);
        $microred7 = MicroRed::firstOrCreate(['nombre' => 'SAN PEDRO DE CHAULAN', 'red_id' => 1]);
        $microred8 = MicroRed::firstOrCreate(['nombre' => 'SAN PABLO DE PILLAO', 'red_id' => 1]);
        $microred9 = MicroRed::firstOrCreate(['nombre' => 'SAN FRANCISCO DE MOSCA', 'red_id' => 2]);
        $microred10 = MicroRed::firstOrCreate(['nombre' => 'SAN FRANCISCO DE CAYRAN', 'red_id' => 1]);
        $microred11 = MicroRed::firstOrCreate(['nombre' => 'RED DE SALUD PACHITEA', 'red_id' => 3]);
        $microred12 = MicroRed::firstOrCreate(['nombre' => 'RED DE SALUD DE HUANUCO', 'red_id' => 1]);
        $microred13 = MicroRed::firstOrCreate(['nombre' => 'RED DE SALUD AMBO', 'red_id' => 2]);
        $microred14 = MicroRed::firstOrCreate(['nombre' => 'POTRACANCHA', 'red_id' => 1]);
        $microred15 = MicroRed::firstOrCreate(['nombre' => 'PANAO', 'red_id' => 3]);
        $microred16 = MicroRed::firstOrCreate(['nombre' => 'MOLINO', 'red_id' => 3]);
        $microred17 = MicroRed::firstOrCreate(['nombre' => 'MARGOS', 'red_id' => 1]);
        $microred17 = MicroRed::firstOrCreate(['nombre' => 'HUANCAPALLAC', 'red_id' => 1]);
        $microred19 = MicroRed::firstOrCreate(['nombre' => 'HUACAR', 'red_id' => 2]);
        $microred20 = MicroRed::firstOrCreate(['nombre' => 'CONCHAMARCA', 'red_id' => 2]);
        $microred21 = MicroRed::firstOrCreate(['nombre' => 'COLPAS', 'red_id' => 2]);
        $microred22 = MicroRed::firstOrCreate(['nombre' => 'CHURUBAMBA', 'red_id' => 1]);
        $microred23 = MicroRed::firstOrCreate(['nombre' => 'CHAGLLA', 'red_id' => 3]);
        $microred24 = MicroRed::firstOrCreate(['nombre' => 'CAYNA', 'red_id' => 2]);
        $microred25 = MicroRed::firstOrCreate(['nombre' => 'CARLOS SHOWING FERRARI', 'red_id' => 1]);
        $microred26 = MicroRed::firstOrCreate(['nombre' => 'APARICIO POMARES', 'red_id' => 1]);
        $microred27 = MicroRed::firstOrCreate(['nombre' => 'AMBO', 'red_id' => 2]);
        $microred28 = MicroRed::firstOrCreate(['nombre' => 'AMARILIS', 'red_id' => 1]);
        $microred29 = MicroRed::firstOrCreate(['nombre' => 'ACOMAYO', 'red_id' => 1]);
    }
}
