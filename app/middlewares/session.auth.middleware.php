<?php
    function sessionAuthMiddleware($res) { 
        session_start(); //inicio sesion en php, si ya estaba activa se reabre
        if (isset($_SESSION['ID_usuario'])){ //verifica si existe una clave 'nombre_usuario' en $_SESSION
            $res-> usuario = new stdClass(); //crea un obj vacio
            $res-> usuario->ID_usuario = $_SESSION['ID_usuario'];
            $res-> usuario->nombre_usuario = $_SESSION['nombre_usuario'];
            //guarda el ID_user y el nombre dentro de ese obj de respuesta $res.
            return;
        } else {
            $res->usuario = null;
        }
    }
?>