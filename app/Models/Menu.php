<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable =['id','nombre','slug','icono','padre_id','orden'];
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function padre()
    {
        return $this->belongsTo(Menu::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class,'padre_id');
    }
}
