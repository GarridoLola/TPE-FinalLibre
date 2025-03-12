<?php

class authVista {

    public function mostrarLogin($error = ''){
        $usuario = null;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/form_login.phtml';
    }
}