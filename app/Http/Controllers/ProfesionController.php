<?php

namespace App\Http\Controllers;

use App\Models\Profesion;
use Illuminate\Http\Request;

class ProfesionController extends Controller
{
    public function todos(){
        $cargos = Profesion::get();
        return $cargos;
    }
}
