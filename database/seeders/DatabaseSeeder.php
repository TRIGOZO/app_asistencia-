<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OficinaSeeder::class,
            TipoPermisoSeeder::class,
            CargoSeeder::class,
            EstadoCivilSeeder::class,
            RedSeeder::class,
            CondicionSeeder::class,
            MicroRedSeeder::class,
            EstablecimientoSeeder::class,
            RoleSeeder::class,
            TipoTrabajadorSeeder::class,
            ProfesionSeeder::class,
            PersonalSeeder::class,
            UserSeeder::class,
            EstadoCivilSeeder::class,
            MenuSeeder::class,
            TipoTurnoSeeder::class,
            UbigeoSeeder::class,
        ]);
    }
}
