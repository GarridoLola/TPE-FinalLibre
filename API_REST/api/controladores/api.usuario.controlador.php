<?php

require_once 'api/modelos/api.usuario.modelo.php';
require_once 'api/vistas/json.vista.php';
require_once 'libs/jwt.php';

class ApiUserControlador {
    private $modelo;
    private $vista;

    public function __construct() {
        $this->modelo = new userApiModelo();
        $this->vista= new JSONVista();
    }

    public function obtenerToken() {
        // obtengo el nombre de usuario y la contraseña desde el header
        $auth_header = $_SERVER['HTTP_AUTHORIZATION']; // "Basic dXN1YXJpbw=="
        $auth_header = explode(' ', $auth_header); // ["Basic", "dXN1YXJpbw=="]
        
        if(count($auth_header) != 2) {
            return $this->vista->response("Los datos ingresados no son correctos", 400);
        }
        if($auth_header[0] != 'Basic') {
            return $this->vista->response("Los datos ingresados no son correctos", 400);
        }
       
        $user_pass = base64_decode($auth_header[1]); // "usuario:contraseña"
        $user_pass = explode(':', $user_pass); // ["usuario", "contraseña]
        
        $user = $this->modelo->obtenerUsuario($user_pass[0]);
        
        if($user == null || !password_verify($user_pass[1], $user->contraseña)) {
            return $this->vista->response("Error en los datos ingresados", 400);
        }
        // genero token
        $token = createJWT(array(
            'sub' => $user->ID_usuario,
            'nombre_usuario' => $user->nombre_usuario,
            'role' => 'admin',
            'iat' => time(),
            'exp' => time() + 600,
            'Saludo' => 'Hola',
        ));
        return $this->vista->response($token);
    }
}
