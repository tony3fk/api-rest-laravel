<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function pruebas(Request $request){
        return "Acci�n de pruebas de Post controller";
    }
}
