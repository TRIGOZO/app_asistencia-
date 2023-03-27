<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::select('id')->where('nombre','Super Usuario')->first();

        $menu1 = Menu::firstOrCreate(['nombre' => 'Dashboard','slug' => 'principal',
                                    'icono' => 'fas fa-gauge fa-fw', 'padre_id' => null,'orden' => 0
                                    ]);

        $menu2 = Menu::firstOrCreate(['nombre' => 'Sistema','slug' => 'sistema',
                                    'icono' => 'fab fa-windows fa-fw', 'padre_id' => null,'orden' => 1
                                    ])
        ;

        $menu3 = Menu::firstOrCreate(['nombre' => 'Configuraciones','slug' => 'configuracion',
                                    'icono' => 'fas fa-cogs', 'padre_id' => null,'orden' => 2
        ])
        ;
        $menu4 = Menu::firstOrCreate(['nombre' => 'Personal','slug' => 'personal',
                                    'icono' => 'fa-solid fa-users', 'padre_id' => 3,'orden' => 1
        ])
        ;
        $menu5 = Menu::firstOrCreate(['nombre' => 'Usuarios','slug' => 'usuarios',
                                    'icono' => 'fa-solid fa-users', 'padre_id' => 2,'orden' => 2
        ])
        ;
        $menu5 = Menu::firstOrCreate(['nombre' => 'Menus','slug' => 'menus',
                                    'icono' => 'fas fa-bars fa-fw', 'padre_id' => 2,'orden' => 3
        ])
        ;
        $menu6 = Menu::firstOrCreate(['nombre' => 'Menus Roles','slug' => 'menus-roles',
                                    'icono' => 'fas fa-user-minus fa-fw', 'padre_id' => 2,'orden' => 4
        ])
        ;
        $role1->menus()->sync([$menu1->id,$menu2->id,$menu3->id, $menu4->id, $menu5->id]);

    }
}
