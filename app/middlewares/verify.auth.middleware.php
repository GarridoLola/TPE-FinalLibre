<?php 
    function verifyAuthMiddleware ($res) { 
        if ($res->usuario) { //verifico si existe un obj user en $res (si el usuario ha sido autenticado).
            return;
        } else {
            header ('Location:' . BASE_URL . 'mostrarLogin'); //redirige a la pág del login
            die();  //detengo ejecución
        }
    } 
