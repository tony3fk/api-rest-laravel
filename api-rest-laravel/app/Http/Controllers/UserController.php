<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function pruebas(Request $request){
        return "Acci�n de pruebas de user controller";
    }
    
    public function register(Request $request){
        
        $name=$request->input('name');
        $surname=$request->input('surname');
        return "Acci�n de registro del usuarios: $name, $surname";
    }
    
    public function login(Request $request){
        return "Acci�n de login de usuarios";
    }
}
