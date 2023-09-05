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
        $microred1 = MicroRed::firstOrCreate(['CODIGO' => '100101000','nombre' => 'HUANUCO', 'red_id' => 1]);
        $microred1 = MicroRed::firstOrCreate(['CODIGO' => '100102000','nombre' => 'AMARILIS', 'red_id' => 1]);
        $microred1 = MicroRed::firstOrCreate(['CODIGO' => '100103000','nombre' => 'CHINCHAO', 'red_id' => 1]);
        $microred1 = MicroRed::firstOrCreate(['CODIGO' => '100104000','nombre' => 'CHURUBAMBA', 'red_id' => 1]);
        $microred1 = MicroRed::firstOrCreate(['CODIGO' => '100105000','nombre' => 'MARGOS', 'red_id' => 1]);
        $microred1 = MicroRed::firstOrCreate(['CODIGO' => '100106000','nombre' => 'HUANCAPALLAC', 'red_id' => 1]);
        $microred1 = MicroRed::firstOrCreate(['CODIGO' => '100107000','nombre' => 'CAYRAN', 'red_id' => 1]);
        $microred1 = MicroRed::firstOrCreate(['CODIGO' => '100108000','nombre' => 'SAN PEDRO DE CHAULAN', 'red_id' => 1]);
        $microred1 = MicroRed::firstOrCreate(['CODIGO' => '100109000','nombre' => 'SANTA MARIA DEL VALLE', 'red_id' => 1]);
        $microred1 = MicroRed::firstOrCreate(['CODIGO' => '100110000','nombre' => 'YARUMAYO', 'red_id' => 1]);
        $microred1 = MicroRed::firstOrCreate(['CODIGO' => '100111000','nombre' => 'PILLCO MARCA', 'red_id' => 1]);
        $microred1 = MicroRed::firstOrCreate(['CODIGO' => '100112000','nombre' => 'YACUS', 'red_id' => 1]);
        $microred1 = MicroRed::firstOrCreate(['CODIGO' => '100113000','nombre' => 'PILLAO', 'red_id' => 1]);
    }
}
