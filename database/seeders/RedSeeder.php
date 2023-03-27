<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Red;
class RedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $red = Red::firstOrCreate(['nombre' => 'HUANUCO']);
        $red = Red::firstOrCreate(['nombre' => 'AMBO']);
        $red = Red::firstOrCreate(['nombre' => 'PACHITEA']);
    }
}
