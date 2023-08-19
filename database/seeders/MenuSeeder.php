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
        $role1 = Role::where('nombre', 'Super Usuario')->first();

        $menuspadres = [
            [
                'nombre' => 'Dashboard',
                'slug' => 'principal',
                'icono' => 'fas fa-gauge fa-fw',
                'padre_id' => null,
                'orden' => 0,
            ],
            [
                'nombre' => 'Sistema',
                'slug' => 'sistema',
                'icono' => 'fab fa-windows fa-fw',
                'padre_id' => null,
                'orden' => 1,
            ],
            [
                'nombre' => 'Configuraciones',
                'slug' => 'configuracion',
                'icono' => 'fas fa-cogs',
                'padre_id' => null,
                'orden' => 2,
            ],
            [
                'nombre' => 'Personal',
                'slug' => 'personal',
                'icono' => 'fas fa-id-badge',
                'padre_id' => null,
                'orden' => 3,
            ],
            [
                'nombre' => 'Asistencia',
                'slug' => 'asistencia',
                'icono' => 'fa-solid fa-users',
                'padre_id' => null,
                'orden' => 4,
            ],
            [
                'nombre' => 'Reportes',
                'slug' => 'reportes',
                'icono' => 'fas fa-chart-bar',
                'padre_id' => null,
                'orden' => 4,
            ],            
        ];
        foreach ($menuspadres as $menuData) {
            $menu = Menu::firstOrCreate($menuData);
        }
        $menusData = [
            [
                'nombre' => 'Usuarios',
                'slug' => 'usuarios',
                'icono' => 'fa-solid fa-users',
                'padre_id' => Menu::where('nombre', 'Sistema')->value('id'),
                'orden' => Menu::where('nombre', 'Sistema')->max('orden')+1,
            ],
            [
                'nombre' => 'Role',
                'slug' => 'role',
                'icono' => 'fas fa-user-lock',
                'padre_id' => Menu::where('nombre', 'Sistema')->value('id'),
                'orden' => Menu::where('nombre', 'Sistema')->max('id')+1,
            ], 
            [
                'nombre' => 'Menus',
                'slug' => 'menus',
                'icono' => 'fas fa-bars fa-fw',
                'padre_id' => Menu::where('nombre', 'Sistema')->value('id'),
                'orden' => Menu::where('nombre', 'Sistema')->max('id')+1,
            ],
            [
                'nombre' => 'Menus Roles',
                'slug' => 'menus-roles',
                'icono' => 'fas fa-user-minus fa-fw',
                'padre_id' => Menu::where('nombre', 'Sistema')->value('id'),
                'orden' => Menu::where('nombre', 'Sistema')->max('id')+1,
            ],
            [
                'nombre' => 'Red',
                'slug' => 'red',
                'icono' => 'fas fa-building',
                'padre_id' => Menu::where('nombre', 'Configuraciones')->value('id'),
                'orden' => Menu::where('nombre', 'Configuraciones')->max('id')+1,
            ],
            [
                'nombre' => 'MicroRed',
                'slug' => 'microred',
                'icono' => 'fas fa-briefcase',
                'padre_id' => Menu::where('nombre', 'Configuraciones')->value('id'),
                'orden' => Menu::where('nombre', 'Configuraciones')->max('id')+1,
            ], 
            [
                'nombre' => 'Establecimiento',
                'slug' => 'establecimiento',
                'icono' => 'fas fa-briefcase',
                'padre_id' => Menu::where('nombre', 'Configuraciones')->value('id'),
                'orden' => Menu::where('nombre', 'Configuraciones')->max('id')+1,
            ],             
            [
                'nombre' => 'Profesiones',
                'slug' => 'profesion',
                'icono' => 'fas fa-university',
                'padre_id' => Menu::where('nombre', 'Configuraciones')->value('id'),
                'orden' => Menu::where('nombre', 'Configuraciones')->max('id')+1,
            ],
            [
                'nombre' => 'Tipo Guardia',
                'slug' => 'tipo-guardia',
                'icono' => 'fas fa-university',
                'padre_id' => Menu::where('nombre', 'Configuraciones')->value('id'),
                'orden' => Menu::where('nombre', 'Configuraciones')->max('id')+1,
            ],
            [
                'nombre' => 'Cargos',
                'slug' => 'cargo',
                'icono' => 'fas fa-university',
                'padre_id' => Menu::where('nombre', 'Configuraciones')->value('id'),
                'orden' => Menu::where('nombre', 'Configuraciones')->max('id')+1,
            ], 
            [
                'nombre' => 'Tipo Turno',
                'slug' => 'tipo-turno',
                'icono' => 'fas fa-university',
                'padre_id' => Menu::where('nombre', 'Configuraciones')->value('id'),
                'orden' => Menu::where('nombre', 'Configuraciones')->max('id')+1,
            ],
            [
                'nombre' => 'Tipo Trabajador',
                'slug' => 'tipo-trabajador',
                'icono' => 'fas fa-hard-hat',
                'padre_id' => Menu::where('nombre', 'Configuraciones')->value('id'),
                'orden' => Menu::where('nombre', 'Configuraciones')->max('id')+1,
            ], 
            [
                'nombre' => 'Tipo Permisos',
                'slug' => 'tipo-permiso',
                'icono' => 'fas fa-shield-alt',
                'padre_id' => Menu::where('nombre', 'Configuraciones')->value('id'),
                'orden' => Menu::where('nombre', 'Configuraciones')->max('id')+1,
            ],
            [
                'nombre' => 'Feriados',
                'slug' => 'feriado',
                'icono' => 'fas fa-umbrella-beach',
                'padre_id' => Menu::where('nombre', 'Configuraciones')->value('id'),
                'orden' => Menu::where('nombre', 'Configuraciones')->max('id')+1,
            ],      
            [
                'nombre' => 'Tipo de Niveles',
                'slug' => 'tipo-nivel',
                'icono' => 'fas fa-sitemap',
                'padre_id' => Menu::where('nombre', 'Configuraciones')->value('id'),
                'orden' => Menu::where('nombre', 'Configuraciones')->max('id')+1,
            ],
            [
                'nombre' => 'Niveles',
                'slug' => 'nivel',
                'icono' => 'fas fa-sitemap-branch',
                'padre_id' => Menu::where('nombre', 'Configuraciones')->value('id'),
                'orden' => Menu::where('nombre', 'Configuraciones')->max('id')+1,
            ],   
            [
                'nombre' => 'Condicion Laboral',
                'slug' => 'condicion-laboral',
                'icono' => 'fas fa-sitemap-branch',
                'padre_id' => Menu::where('nombre', 'Configuraciones')->value('id'),
                'orden' => Menu::where('nombre', 'Configuraciones')->max('id')+1,
            ],                                                                     
            [
                'nombre' => 'Personales',
                'slug' => 'personales',
                'icono' => 'fas fa-user-circle',
                'padre_id' => Menu::where('nombre', 'Personal')->value('id'),
                'orden' => Menu::where('nombre', 'Personal')->max('id')+1,
            ],
            [
                'nombre' => 'Permisos', //SOLICITUD DE PERMISO DESDE EL USUARIO, ME GUIARE DE LA PAPELETA
                'slug' => 'permisos',
                'icono' => 'fas fa-user-shield',
                'padre_id' => Menu::where('nombre', 'Asistencia')->value('id'),
                'orden' => Menu::where('nombre', 'Asistencia')->max('id')+1,
            ],
            [
                'nombre' => 'Rol de Turnos', //establecer al administrativo y poner a que turno pertenece
                'slug' => 'rol',
                'icono' => 'fas fa-user-shield',
                'padre_id' => Menu::where('nombre', 'Asistencia')->value('id'),
                'orden' => Menu::where('nombre', 'Asistencia')->max('id')+1,
            ],
            [
                'nombre' => 'Marcaciones', //establecer al administrativo y poner a que turno pertenece
                'slug' => 'marcacion',
                'icono' => 'fas fa-user-shield',
                'padre_id' => Menu::where('nombre', 'Asistencia')->value('id'),
                'orden' => Menu::where('nombre', 'Asistencia')->max('id')+1,
            ],
            [
                'nombre' => 'Cambio de Turno', //establecer al administrativo y poner a que turno pertenece
                'slug' => 'cambio-turno',
                'icono' => 'fas fa-user-shield',
                'padre_id' => Menu::where('nombre', 'Asistencia')->value('id'),
                'orden' => Menu::where('nombre', 'Asistencia')->max('id')+1,
            ],
                                      
        ];
        
        foreach ($menusData as $menuData) {
            $menu = Menu::updateOrCreate(['slug' => $menuData['slug']], $menuData);
        }
        
        $role1->menus()->sync(Menu::pluck('id'));

    }
}
