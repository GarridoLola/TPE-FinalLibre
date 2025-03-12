<?php

class homeControlador{
    private $usuario;

    public function __construct($res){
        $this->usuario = $res->usuario;
    }

    public function mostrarHome(){
        $usuario = $this->usuario;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/home.phtml';
    }
}