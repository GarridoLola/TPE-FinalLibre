<?php 
 
 require_once 'api/modelos/api.alimentos.modelo.php';
 require_once 'api/controladores/api.usuario.controlador.php';
 require_once 'api/vistas/json.vista.php';

 class apiAlimentosControlador{
    private $modelo;
    private $vista;

    public function __construct() {
        $this->modelo = new alimentosModelo();
        $this->vista =  new JSONVista();
    }

    //GET, api/alimentos

    public function obtenerTodos($req, $res){
        $orderBy = false;
        if (isset($req->query->orderBy)){
            $orderBy = $req->query->orderBy;
        }

        $orderDirection = 'ASC';
        if (isset($req->query->orderDirection)){
            $orderDirection = $req->query->orderDirection;
        }

        
        $filtro = null;
        if (isset($req->query->filtro)){
            $filtro = $req->query->filtro;
        }

        $valor = null;
        if (isset($req->query->valor)){
            $valor = $req->query->valor;
            if ($valor < 0){
                return $this->vista->response("El número debe ser positivo", 400);
            }
        }

        //paginacion
        $pagina = 1;
        if (isset($req->query->pagina)){
            $pagina = $req->query->pagina;
            if ($pagina < 0){
                return $this->vista->response("El número debe ser positivo", 400);
            }
        }

        $limite = null;
        if (isset($req->query->limite)){
            $limite = $req->query->limite;
            if ($limite < 0){
                return $this->vista->response("El número debe ser positivo", 400);
            }
        }

        $alimentos = $this->modelo->obtenerTodosAlimentos($orderBy, $orderDirection, $valor, $filtro, $pagina, $limite);
        
        if (!$alimentos){
            return $this->vista->response("No se encontraron alimentos con ese filtro", 404);
        }
        //mando a la vista
        return $this->vista->response($alimentos, 200);
    }

     //GET, api/alimentos/:id
    public function obtenerAlimento($req, $res){
        $id = $req->params->id;

        $alimento = $this->modelo->obtenerAlimento($id);
        if (!$alimento){
            return $this->vista->response("El alimento con el ID= $id no existe", 404);
        }
        return $this->vista->response($alimento);
    }
    
    //DELETE, api/alimentos/:id
    public function borrarAlimento($req, $res){
        $id = $req->params->id;
        
        $alimento = $this->modelo->obtenerAlimento($id);
        if (!$alimento){
            return $this->vista->response("El alimento con el ID= $id no existe", 404);
        }

        $this->modelo->eliminarAlimento($id);
        $this->vista->response("El alimento con el ID= $id se ha eliminado con éxito", 200);
    }


    //POST, api/alimentos
    public function agregarAlimento($req, $res){

        if (!$res->user){
            return $this->vista->response("No autorizado", 401);
        }
        
        //valido los datos.
        if (empty($req->body->nombre_alimento) || empty($req->body->descripcion_alimento) || empty($req->body->calorias) || 
            empty($req->body->proteinas) || empty($req->body->carbohidratos) || empty($req->body->grasas) || empty($req->body->fibra)){
                return $this->vista->response("Faltan completar datos", 400);
        }

        //obtengo los datos
        $nombre_alimento = $req->body->nombre_alimento;
        $descripcion_alimento = $req->body->descripcion_alimento;
        $ID_grupos = $req->body->ID_grupos;
        $calorias = $req->body->calorias;
        $proteinas = $req->body->proteinas;
        $carbohidratos = $req->body->carbohidratos;
        $grasas = $req->body->grasas;
        $fibra = $req->body->fibra;
        $imagen_alimento = $req->body->imagen_alimento;

        //inserto
        $id = $this->modelo->insertarAlimento($nombre_alimento, $ID_grupos, $descripcion_alimento, $calorias, $proteinas, $carbohidratos, $grasas, $fibra, $imagen_alimento);

        if (!$id) {
            return $this->vista->response("Error al insertar alimento", 500);
        }

        $alimento = $this->modelo->obtenerAlimento($id);
        return $this->vista->response($alimento, 201);
    }

    //PUT, api/alimentos/:id
    public function actualizarAlimento($req, $res){

        if (!$res->user){
            return $this->vista->response("No autorizado", 401);
        }

        $id = $req->params->id;
        $alimento = $this->modelo->obtenerAlimento($id);
        
        if (!$id){
            return $this->vista->response("El alimento con el ID= $id no existe", 404);
        }

        if (empty($req->body->nombre_alimento) || empty($req->body->descripcion_alimento) || empty($req->body->calorias) || 
            empty($req->body->proteinas) || empty($req->body->carbohidratos) || empty($req->body->grasas) || empty($req->body->fibra)){
                return $this->vista->response("Faltan completar datos", 400);
        }

        $nombre_alimento = $req->body->nombre_alimento;
        $descripcion_alimento = $req->body->descripcion_alimento;
        $ID_grupos = $req->body->ID_grupos;
        $calorias = $req->body->calorias;
        $proteinas = $req->body->proteinas;
        $carbohidratos = $req->body->carbohidratos;
        $grasas = $req->body->grasas;
        $fibra = $req->body->fibra;
        $imagen_alimento = $req->body->imagen_alimento;

        //actualizo
        $this->modelo->editarAlimento($nombre_alimento, $ID_grupos, $descripcion_alimento, $calorias, $proteinas, $carbohidratos, $grasas, $fibra, $imagen_alimento, $id);
        
        //lo obtengo y lo devuelvo en la respuesta
        $alimento = $this->modelo->obtenerAlimento($id);
        $this->vista->response($alimento, 200);
    }
 }