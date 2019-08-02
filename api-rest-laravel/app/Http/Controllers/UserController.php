<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    public function pruebas(Request $request)
    {
        return "Acción de pruebas de user controller";
    }

    public function register(Request $request)
    {

        // Recoger los datos del usuario por POST
        $json = $request->input('json', null);

        $params_array = json_decode($json, true); // array

        $params = json_decode($json); // objeto

        if (! empty($params_array) && ! empty($params)) {

            // limpiar datos
            $params_array = array_map('trim', $params_array);
            // $params = array_map('trim', $params);

            // Validar datos

            $validate = \Validator::make($params_array, [
                'name' => 'required|alpha',
                'surname' => 'required|alpha',
                'email' => 'required|email|unique:users', // comprobar si el usuario ya existe
                'password' => 'required'
            ]);

            if ($validate->fails()) {

                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'El usuario no se ha creado',
                    'errors' => $validate->errors()
                );
            } else {

                // validación pasada correctamente
                // cifrar la contraseña

                $pwd =hash('sha256', $params->password);

                // crear el usuario
                $user = new User();
                $user->name = $params_array['name'];
                $user->surname = $params_array['surname'];
                $user->email = $params_array['email'];
                $user->password = $pwd;
                $user->role = 'ROLE_USER';

                // guardar el usuario
                $user->save();
                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'El usuario se ha creado correctamente',
                    'user' => $user
                );
            }
        } else {
            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'Los datos enviados no son correctos'
            );
        }

        return response()->json($data, $data['code']);
    }

    public function login(Request $request)
    {
        $JwtAuth = new \JwtAuth();
        
        
        $email='tony3fk@gmail.com';
        $password='tony';
        $pwd=hash('sha256', $password);
        
        return response()->json($JwtAuth->signup($email, $pwd, true), 200);

        // recibir datos por POST
 /*       $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        // Validar esos datos
        $validate = \Validator::make($params_array, [
            'email' => 'required|email', // comprobar si el usuario ya existe
            'password' => 'required'
        ]);

        if ($validate->fails()) {
        //si la validacion falla
            $signup = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'El usuario no se ha podido loguear',
                'errors' => $validate->errors()
            );
        } else {

            // validación pasada correctamente
            // cifrar la contraseña

            $pwd = hash('sha256', $params->password);

            // Devolver token o datos

            $signup = $JwtAuth->signup($params->email, $pwd);

            if (!empty($params->gettoken)) {
                $signup = $JwtAuth->signup($params->email, $pwd, true);
            }
        }
        return response()->json($signup, 200);                                                      */
        //var_dump($params_array);
        
        //die();
    }
}


/*namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function pruebas(Request $request){
        return "Accion de pruebas de User - Controller";
    }
    
    public function register(Request $request)
    {
        //Recoger los datos del usuario por post********************************
        $json = $request->input('json', null);
        $params = json_decode($json); //Objeto
        //var_dump($params->name); die(); este es el objeto especifico que se obtiene
        $params_array = json_decode($json, true); //Array
        //var_dump($params_array); die(); esta es la forma de obtenerlo en un array
        
        //Validar datos vacios**************************************************
        if(!empty($params) && !empty($params_array))
        {
            //Limpiar datos*****************************************************
            $params_array = array_map('trim', $params_array);
            
            //Validar datos ****************************************************
            $validate = \Validator::make($params_array, [
                'name'      =>  'required|alpha',
                'surname'   =>  'required|alpha',
                'email'     =>  'required|email|unique:users',
                'password'  =>  'required'
            ]);
            
            if($validate->fails())
            {
                //La validacion ha fallado
                $data = Array(
                    'status'    =>  'error',
                    'code'      =>  404,
                    'message'   =>  'El usuario no se ha creado',
                    'errors'    =>  $validate->errors()
                    );
            }
            else
            {
                //Validacion pasada correctamente
                //Cifrar la contraseña******************************************
                // $pwd = password_hash($params->password, PASSWORD_BCRYPT, ['cost' => 4]);  //Este es un sistema de cifrado que varia la password
                $pwd = hash('sha256', $params->password);
                
                //Crear al usuario**********************************************
                $user = new User();
                $user->name     = $params_array['name'];
                $user->surname  = $params_array['surname'];
                $user->email    = $params_array['email'];
                $user->password = $pwd;
                $user->role     = 'ROLE_USER';
                
                //Guardar el usuario********************************************
                $user->save();
                
                $data = Array(
                    'status'    =>  'success',
                    'code'      =>  200,
                    'message'   =>  'El usuario se ha creado correctamente',
                    'user'      =>  $user
                    );
            }
        }
        else
        {
            $data = Array(
                'status'    =>  'error',
                'code'      =>  404,
                'message'   =>  'Los datos enviados no son correctos'
                );
        }
        
        return response()->json($data, $data['code']);
    }
    
    
    public function login(Request $request)
    {
        $jwtAuth = new \JwtAuth();
        
        // Recibir datps por post
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);
        // var_dump($params_array);
        // die();
        // Validar esos datos
        $validate = \Validator::make($params_array, [
            'email'     =>  'required|email',
            'password'  =>  'required'
        ]);
        
        if ($validate->fails())
        {
            //La validacion ha fallado
            $signup = array(
                'status'    =>  'error',
                'code'      =>  404,
                'message'   =>  'El usuario no se ha podido identificar',
                'errors'    =>  $validate->errors()
            );
        }else
        {
            // Cifrar la password
            $pwd = hash('sha256', $params->password);
            // Devolver token o datos
            $signup = $jwtAuth->signup($params->email, $pwd);
            
            if(!empty($params->gettoken))
            {
                $signup = $jwtAuth->signup($params->email, $pwd, true);
            }
        }
        
        return response()->json($signup, 200);
    }
    
}/*
?>
