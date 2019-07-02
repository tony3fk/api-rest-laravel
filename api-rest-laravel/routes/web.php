<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//rutas de prueba
Route::get('/', function(){
    return '<h1>Hola mundo con Laravel</h1>';
});

Route::get('/welcome', function () {
    return view('welcome');
});


Route::get('/pruebas/{nombre?}', function($nombre=null){
    $texto='<h2>Texto desde una ruta</h2>';
    $texto.='Nombre: '.$nombre;
    return view('pruebas', array(
        'texto'=>$texto
        
    ));
});

Route::get('/animales','PruebasController@index');
Route::get('/test-orm','PruebasController@testOrm');

//rutas del API

        /*metodos http comunes:
         * GET: conseguir datos o recursos.
         * POST: guardar datos o recursos o hacer logica desde un formulario.
         * PUT: Actualizar datos o recursos.
         * DELETE: Eliminar datos o recursos.
         * 
        */

        //rutas de prueba
        Route::get('/usuario/pruebas','UserController@pruebas');
        Route::get('/categoria/pruebas','CategoryController@pruebas');
        Route::get('/entrada/pruebas','PostController@pruebas');
        
        
        //rutas del controlador de usuarios
        Route::post('/api/register','UserController@register');
        Route::post('/api/login','UserController@login');
        
        
        
        
        