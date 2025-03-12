<?php

class gruposVista {
    private $usuario;

    public function __construct($usuario = null) {
        $this->usuario = $usuario;
    }
        
    public function listarGrupos($grupos) {
        $usuario = $this->usuario;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/listar_grupos.phtml';
    }

    public function listarItemPorGrupo($alimentos, $nombre_grupo){
        $usuario = $this->usuario;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/listar_items.phtml';
    }

    public function formEditarGrupo($grupo){
        $usuario = $this->usuario;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/form_editar_grupo.phtml';
    }
    

    public function adminGrupos($grupos_alimentos){
        $usuario = $this->usuario;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/form_agregar_grupo.phtml';
    }

    public function mostrarExito($exito){
        $usuario = $this->usuario;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/exito.phtml';
    }
    
    public function mostrarError($error) {
        $usuario = $this->usuario;
        require_once 'templates/layout/header.phtml';
        require_once 'templates/error.phtml';
    }

}