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

        
        $params_array = json_decode($json, true);//array
        
        $params = json_decode($json);//objeto

        

        if (!empty($params_array) && !empty($params)) {
            
            // limpiar datos
            $params_array = array_map('trim', $params_array);
            //$params = array_map('trim', $params);

            // Validar datos

            $validate = \Validator::make($params_array, [
                'name' => 'required|alpha',
                'surname' => 'required|alpha',
                'email' => 'required|email|unique:users',   // comprobar si el usuario ya existe
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
                
                //validación pasada correctamente
                // cifrar la contraseña
                
                $pwd = password_hash($params->password, PASSWORD_BCRYPT, ['cost' => 4]);
                
                
                // crear el usuario
                $user = new User();
                $user->name = $params_array['name'];
                $user->surname = $params_array['surname'];
                $user->email = $params_array['email'];
                $user->password = $pwd;
                $user->role = 'ROLE_USER';
                
               
                
              //guardar el usuario
              $user->save();
                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'El usuario se ha creado correctamente',
                    'user' => $user
                    
                );
            }
        }else{
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
        return "Acción de login de usuarios";
    }
}
