<?php

class alimentosVista {
    private $usuario;

    public function __construct($usuario = null) {
        $this->usuario = $usuario;
    }

    public function listarAlimentos($alimentos, $grupos_alimentos = null) {
        $grupos = $grupos_alimentos;
        $usuario = $this->usuario;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/listar_alimentos.phtml';
    }

    public function mostrarDetalles($alimento){
        $usuario = $this->usuario;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/alimento_detalle.phtml';
    }

    public function formEditarAlimento($alimento, $grupos_alimentos = []){ //por si viene vacío.
        $grupos = $grupos_alimentos;
        $usuario = $this->usuario;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/form_editar_alimento.phtml';
    }

    public function adminAlimentos($alimentos, $grupos_alimentos){
        $grupos = $grupos_alimentos;
        $usuario = $this->usuario;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/form_agregar_alimento.phtml';
    }

    public function alertaExito($exito){
        $usuario = $this->usuario;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/exito.phtml';
    }
    

    public function alertaError($error){
        $usuario = $this->usuario;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/error.phtml';
        
    }
}