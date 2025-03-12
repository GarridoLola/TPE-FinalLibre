<?php

require_once 'app/modelos/alimentos.modelo.php';
require_once 'app/modelos/grupos.modelo.php';
require_once 'app/vistas/alimentos.vista.php';

class alimentosControlador{
    private $modelo;
    private $vista;
    private $adminGruposModelo;

    public function __construct($res = null){ //si no se pasa un valor, se le asigna null.
        $this->modelo = new alimentosModelo();
        $this->vista = new alimentosVista($res ? $res->usuario: null); //si $res tiene datos, pasa a $res->usuario, sino pasa a null. Permite que la 
        //vista decida que mostrar según si el usuario esta logueado ono 
        $this->adminGruposModelo = new gruposModelo;
    }

    public function mostrarAlimentos(){
        $alimentos = $this->modelo->obtenerAlimento();
        $grupos = $this->adminGruposModelo->obtenerGrupos();

        return $this->vista->listarAlimentos($alimentos, $grupos);
    }

    public function alimentosDetalle($ID_alimentos){
        $alimentos = $this->modelo->obtenerAlimentoDetalle($ID_alimentos);

        if ($alimentos) {
            $this->vista->mostrarDetalles($alimentos);
        } else {
            $this->vista->alertaError('Alimento no encontrado.');
        }
    }

    //métodos para admin.
        //administrar 
        public function administrarAlimentos(){
            $alimentos = $this->modelo->obtenerAlimento();
            $grupos = $this->adminGruposModelo->obtenerGrupos();

            $this->vista->adminAlimentos($alimentos, $grupos);
        }


    public function agregarAlimento() {
        if (!isset($_POST['nombre_alimento']) || empty ($_POST['nombre_alimento'])){
            return $this->vista->alertaError('Completa con el nombre del alimento.');
        }
        if (!isset($_POST['descripcion_alimento']) || empty ($_POST['descripcion_alimento'])){
            return $this->vista->alertaError('Completa con las descripción del alimento.');
        }
        if (!isset($_POST['calorias']) ||  trim($_POST['calorias']) === ''){ //sino, no acepta los 0 (pero no cadenas vacías).
            return $this->vista->alertaError('Completa con las calorías del alimento.');
        }
        if (!isset($_POST['proteinas']) || trim($_POST['proteinas']) === ''){
            return $this->vista->alertaError('Completa con las proteinas del alimento.');
        }
        if (!isset($_POST['carbohidratos']) ||  trim($_POST['carbohidratos']) === ''){
            return $this->vista->alertaError('Completa con los carbohidratos del alimento.');
        }
        if (!isset($_POST['grasas']) || trim($_POST['grasas']) === ''){
            return $this->vista->alertaError('Completa con las grasas del alimento.');
        }
        if (!isset($_POST['fibra']) || trim($_POST['fibra']) === ''){
            return $this->vista->alertaError('Completa con las fibra del alimento.');
        }
        if (!isset($_POST['imagen_alimento']) || empty ($_POST['imagen_alimento'])){
            return $this->vista->alertaError('Agregue una imagen (URL) del alimento.');
        }

        $nombre_alimento = $_POST['nombre_alimento'];
        $grupo = $_POST['grupo'];
        $descripcion_alimento = $_POST['descripcion_alimento'];
        $calorias = $_POST['calorias'];
        $proteinas = $_POST['proteinas'];
        $carbohidratos = $_POST['carbohidratos'];
        $grasas = $_POST['grasas'];
        $fibra = $_POST['fibra'];
        $imagen_alimento = $_POST['imagen_alimento'] ?? null; //si no existe, le asigna null.

        $ID_alimentos = $this->modelo->insertarAlimento($nombre_alimento,  $grupo, $descripcion_alimento, $calorias, $proteinas, $carbohidratos, $grasas, $fibra, $imagen_alimento);
        $this->vista->alertaExito("El alimento ha sido agregado correctamente.");
            
        header('Refresh: 2; url=' . BASE_URL . 'admin_alimentos'); //para que muestre el mensaje de éxito.
    }

    public function eliminarAlimento($ID_alimentos){
        $alimento = $this->modelo->obtenerAlimentoDetalle($ID_alimentos);

        if(!$alimento){
            return $this->vista->alertaError('El alimento no existe.');
        }

        $this->modelo->eliminarAlimento($ID_alimentos);
        $this->vista->alertaExito("El alimento ha sido eliminado correctamente.");
            
        header('Refresh: 2; url=' . BASE_URL . 'admin_alimentos'); //para que muestre el mensaje de éxito.
    }

    public function formEditarAlimento($ID_alimentos){
        $alimento = $this->modelo->obtenerAlimentoDetalle($ID_alimentos);
        $grupos = $this->adminGruposModelo->obtenerGrupos();

        if (!$alimento){
            return $this->vista->alertaError('El alimento no existe.');
        }
        
        $this->vista->formEditarAlimento($alimento, $grupos);
    }
    
    public function actualizarAlimento(){
        if (!isset($_POST['ID_alimentos']) || empty ($_POST['ID_alimentos'])){
            return $this->vista->alertaError('Falta el ID_alimentos.');
        }
        if (!isset($_POST['ID_grupos']) || (empty($_POST['ID_grupos']))){
            return $this->vista->alertaError('Complete con el grupo');
        }
        if (!isset($_POST['E_nombre_alimento']) || empty ($_POST['E_nombre_alimento'])){
            return $this->vista->alertaError('Completa con el nombre del alimento.');
        }
        if (!isset($_POST['E_descripcion_alimento']) || empty ($_POST['E_descripcion_alimento'])){
            return $this->vista->alertaError('Completa con las descripción del alimento.');
        }
        if (!isset($_POST['E_calorias']) ||  trim($_POST['E_calorias']) === ''){ //sino no acepta los 0 (pero no cadenas vacías),.
            return $this->vista->alertaError('Completa con las calorías del alimento.');
        }
        if (!isset($_POST['E_proteinas']) || trim($_POST['E_proteinas']) === ''){
            return $this->vista->alertaError('Completa con las proteinas del alimento.');
        }
        if (!isset($_POST['E_carbohidratos']) ||  trim($_POST['E_carbohidratos']) === ''){
            return $this->vista->alertaError('Completa con los carbohidratos del alimento.');
        }

        if (!isset($_POST['E_grasas']) || trim($_POST['E_grasas']) === ''){
            return $this->vista->alertaError('Completa con las grasas del alimento.');
        }

        if (!isset($_POST['E_fibra']) || trim($_POST['E_fibra']) === ''){
            return $this->vista->alertaError('Completa con las fibra del alimento.');
        }

        if (!isset($_POST['E_imagen_alimento']) || empty ($_POST['E_imagen_alimento'])){
            return $this->vista->alertaError('Agregue una imagen (URL) del alimento.');
        }

        $ID_alimentos = $_POST['ID_alimentos'];
        $E_nombre_alimento = $_POST['E_nombre_alimento'];
        $E_grupo = $_POST['ID_grupos'];
        $E_descripcion_alimento = $_POST['E_descripcion_alimento'];
        $E_calorias = $_POST['E_calorias'];
        $E_proteinas = $_POST['E_proteinas'];
        $E_carbohidratos = $_POST['E_carbohidratos'];
        $E_grasas = $_POST['E_grasas'];
        $E_fibra = $_POST['E_fibra'];
        $E_imagen_alimento = $_POST['E_imagen_alimento'] ?? null; //si no existe, le asigna null.

        $this->modelo->actualizarAlimento($ID_alimentos, $E_nombre_alimento, $E_grupo, $E_descripcion_alimento, $E_calorias, $E_proteinas, $E_carbohidratos, $E_grasas, $E_fibra, $E_imagen_alimento);
        $this->vista->alertaExito("El alimento ha sido actualizado correctamente.");
            
        header('Refresh: 2; url=' . BASE_URL . 'admin_alimentos'); //para que muestre el mensaje de éxito.
    }

    public function default(){
        $this->vista->alertaError('Ocurrió un error');
    }
}