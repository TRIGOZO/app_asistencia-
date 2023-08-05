<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Personal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuario = User::firstOrCreate([
            'username' => 'ilandbz',
            'password' => Hash::make('818949'),
            'establecimiento_id' => 27,
            'role_id'   => 1,
            'personal_id'   => 1
        ]);
    }
}
