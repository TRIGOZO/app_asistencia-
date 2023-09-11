<?php

namespace App\Http\Controllers;

use App\Models\Marcacion;
use Illuminate\Http\Request;

class MarcacionController extends Controller
{
    private $marcacion_model;

    public function __construct() {
        $this->marcacion_model = new Marcacion();
    }

    public function obtenerMarcaciones() {
        return $this->marcacion_model->getAllMarcaciones();
    }
}
