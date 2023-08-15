<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['nombre'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * The menus that belong to the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class)->withTimestamps();
    }
    public function asignarMenus($menus)
    {
        if(is_array($menus))
        {
            $this->menus()->sync($menus);
        } else{
            if(count($this->menus) == 0){
                $this->menus()->attach($menus);
            } else {
                foreach($this->menus as $menu)
                {
                    if($menu->id != $menus)
                    {
                        $this->menus()->attach($menus);
                    }
                }
            }
        }
    }
    public function obtenerMenus($roles)
    {
        return Menu::join('menu_role as mr','menus.id','=','mr.menu_id')
                        ->select('menus.id','menus.nombre','menus.slug','menus.icono')
                        ->where('mr.role_id',$roles)
                        ->orderBy('menus.id','asc')->get();
    }    
}
