<?php

namespace Database\Seeders;

use App\Models\DiaMes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiaMesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1;$i<=31;$i++){
            DiaMes::firstorCreate([
                'dia'   => $i
            ]);            
        }
    }
}
