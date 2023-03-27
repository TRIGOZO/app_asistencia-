<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function mostrarmenuslug(Request $request){
        return Menu::where('slug',$request->slug)->first();
    }
}
