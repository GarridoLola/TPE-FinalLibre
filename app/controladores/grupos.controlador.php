<?php

require_once 'app/modelos/grupos.modelo.php';
require_once 'app/vistas/grupos.vistas.php';

class gruposControlador{
    private $modelo;
    private $vista;
    
    public function __construct($res = null){
        $this->modelo = new gruposModelo();
        $this->vista = new gruposVista($res ? $res->usuario: null);
    } 

    public function mostrarGrupos(){
        $grupos_alimentos = $this->modelo->obtenerGrupos();
        return $this->vista->listarGrupos($grupos_alimentos);
    }

    public function mostrarItemsPorGrupo($ID_grupos){
        $alimento= $this->modelo->obtenerItemPorGrupo($ID_grupos);
        $grupos_alimentos = $this->modelo->obtenerIDGrupo($ID_grupos);

        $this->vista->listarItemPorGrupo($alimento, $grupos_alimentos->nombre_grupo);
    }

    //funcionalidad admin.

    //administrar 
    public function administrarGrupos(){
        $grupos = $this->modelo->obtenerGrupos();

        $this->vista->adminGrupos($grupos);
    }

    public function agregarGrupo(){
        if (!isset($_POST['nombre_grupo']) || empty($_POST['nombre_grupo'])){
            return $this->vista->mostrarError('Por favor, agregue el nombre del grupo alimenticio.');
        }

        if (!isset($_POST['descripcion_grupo']) || empty($_POST['descripcion_grupo'])){
            return $this->vista->mostrarError('Por favor, agregue una breve descripción.');
        }

        if (!isset($_POST['imagen_grupo']) || empty($_POST['imagen_grupo'])){
            return $this->vista->mostrarError('Por favor, agregue una imagen.');
        }

        $nombre_grupo = $_POST['nombre_grupo'];
        $descipcion_grupo = $_POST['descripcion_grupo'];
        $imagen_grupo = $_POST['imagen_grupo'] ?? null; //no es null, asigna valor. Es null, asigna null.

        $ID_grupos = $this->modelo->insertarGrupo($nombre_grupo, $descipcion_grupo, $imagen_grupo);
        $this->vista->mostrarExito("El grupo ha sido agregado correctamente.");
            
        header('Refresh: 2; url=' . BASE_URL . 'admin_grupos'); //para que muestre el mensaje de éxito.
    }

    public function eliminarGrupo($ID_grupos){
        $grupos_alimentos = $this->modelo->obtenerGrupos($ID_grupos);

        if(!$grupos_alimentos){
            return $this->vista->mostrarError('El grupo alimenticio no existe.');
        }


        //verifico si tiene alimentos antes de eliminar. 
        $alimentos = $this->modelo->obtenerItemPorGrupo($ID_grupos);
        if (!empty($alimentos)){
            $this->vista->mostrarError('Es necesario que el grupo alimenticio esté vacío para eliminarlo (que no contenga alimentos asociados).');
        } else {
            //si no hay alimentos, la elimina.
            $this->modelo->eliminarGrupo($ID_grupos);

            $this->vista->mostrarExito("El grupo ha sido eliminado correctamente.");
            
            header('Refresh: 2; url=' . BASE_URL . 'admin_grupos'); //para que muestre el mensaje de éxito.
        }
    }

    public function formEditarGrupo($ID_grupos){
        $grupo = $this->modelo->obtenerIDGrupo($ID_grupos);

        if (!$grupo){
            return $this->vista->mostrarError('El grupo que desea actualizar no existe.');
        }
        
        $this->vista->formEditarGrupo($grupo);
    }

    public function actualizarGrupo(){
        if (!isset($_POST['ID_grupos']) || empty($_POST['ID_grupos'])){
            return $this->vista->mostrarError('Falta el ID_grupos.');
        }

        if (!isset($_POST['E_nombre_grupo']) || empty($_POST['E_nombre_grupo'])){
            return $this->vista->mostrarError('Por favor, agregue el nombre del grupo alimenticio.');
        }

        if (!isset($_POST['E_descripcion_grupo']) || empty($_POST['E_descripcion_grupo'])){
            return $this->vista->mostrarError('Por favor, agregue una breve descripción.');
        }

        if (!isset($_POST['E_imagen_grupo']) || empty($_POST['E_imagen_grupo'])){
            return $this->vista->mostrarError('Por favor, agregue una imagen.');
        }

        $ID_grupos = $_POST['ID_grupos'];
        $E_nombre_grupo = $_POST['E_nombre_grupo'];
        $E_descipcion_grupo = $_POST['E_descripcion_grupo'];
        $E_imagen_grupo = $_POST['E_imagen_grupo'] ?? null; //no es null, asigna valor. Es null, asigna null.

        $this->modelo->actualizarGrupo($ID_grupos, $E_nombre_grupo, $E_descipcion_grupo, $E_imagen_grupo);
        $this->vista->mostrarExito("El grupo ha sido actualizado correctamente.");
            
        header('Refresh: 2; url=' . BASE_URL . 'admin_grupos'); //para que muestre el mensaje de éxito.
    }

    public function default(){
        $this->vista->mostrarError('Ocurrió un error');
    }

}