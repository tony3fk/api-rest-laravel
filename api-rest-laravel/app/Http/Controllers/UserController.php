<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{

    public function pruebas(Request $request)
    {
        return "Acci�n de pruebas de user controller";
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

                // validaci�n pasada correctamente
                // cifrar la contrase�a

                $pwd = hash('sha256', $params->password);

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

        // recibir datos por POST
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        // Validar esos datos
        $validate = \Validator::make($params_array, [
            'email' => 'required|email', // comprobar si el usuario ya existe
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            // si la validacion falla
            $signup = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'El usuario no se ha podido loguear',
                'errors' => $validate->errors()
            );
        } else {

            // validaci�n pasada correctamente
            // cifrar la contrase�a

            $pwd = hash('sha256', $params->password);

            // Devolver token o datos

            $signup = $JwtAuth->signup($params->email, $pwd);

            if (! empty($params->gettoken)) {
                $signup = $JwtAuth->signup($params->email, $pwd, true);
            }
        }
        return response()->json($signup, 200);
    }
    
    
    public function update(Request $request){
        
        $token=$request->header('Authorization');
        $jwtAuth=new \JwtAuth();
        $checkToken=$jwtAuth->checkToken($token);
        
        if($checkToken){
            echo "<h1> Login correcto </h1>";
            
        }else{
            echo "<h1> Login INCORRECTO </h1>";
        }
        
        
        die();
        
        
    }
}



?>
