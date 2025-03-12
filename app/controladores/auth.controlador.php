<?php 

require_once 'app/modelos/usuario.modelo.php';
require_once 'app/vistas/auth.vista.php';

class authControlador {
    private $modelo;
    private $vista;

    public function __construct() {
        $this->modelo = new usuarioModelo();
        $this->vista = new authVista();
    }

    public function mostrarLogin() {
        return $this->vista->mostrarLogin();
    }

    public function login() {
        if(!isset($_POST['nombre_usuario']) || empty($_POST['nombre_usuario'])) {
            return $this->vista->mostrarLogin('Falta completar el nombre de usuario.');
        }

        if(!isset($_POST['contraseña']) || empty($_POST['contraseña'])) {
            return $this->vista->mostrarLogin('Falta completar la contraseña.');
        }

        $nombre_usuario = $_POST['nombre_usuario'];
        $contraseña = $_POST['contraseña'];

        //verifico que el usuario esté en la base de datos
        $usuarioDB = $this->modelo->obtenerUsuario($nombre_usuario);

        if (!$usuarioDB) {
            return $this->vista->mostrarLogin('Usuario NO encontrado.');
        }

        if(password_verify($contraseña, $usuarioDB->contraseña)) {
            session_start();
            $_SESSION['ID_usuario'] = $usuarioDB->ID_usuario;
            $_SESSION['nombre_usuario'] = $usuarioDB->nombre_usuario;

            header('Location: ' . BASE_URL . 'admin_alimentos'); 
        } else {
            return $this->vista->mostrarLogin('Credenciales incorrectas.');
        }
    }

    public function logOut() {
        session_start();
        session_destroy();
        header('Location: ' . BASE_URL . 'mostrarLogin');
    }
}