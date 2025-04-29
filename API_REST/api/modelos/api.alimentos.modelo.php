<?php

require_once 'api/modelos/config.php';

class alimentosModelo{
    private $db;

    public function __construct() {
        $this->db = new PDO ("mysql:host=".MYSQL_HOST . ";dbname=".MYSQL_DB. ";charset=utf8", MYSQL_USER, MYSQL_PASS);
        $this->deploy();
    }

    public function deploy() {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if (count($tables) == 0){
            $sql =<<<END

        END;
        $this->db->query($sql);
        }
    }

    public function obtenerTodosAlimentos($orderBy = false, $orderDirection, $valor, $filtro, $pagina, $limite){
        $sql = 'SELECT * FROM alimentos';
      
        //filtrar por campo y por valor
        if ($filtro !==null && $valor!==null) {
            switch ($filtro){
                case 'proteinas':
                    $sql .= ' WHERE proteinas = ? ';
                break;
                case 'calorias': 
                    $sql .= ' WHERE calorias = ?';
                break;
                case 'carbohidratos':
                    $sql .= ' WHERE carbohidratos = ?';
                break;
                case 'fibra': 
                    $sql .= ' WHERE fibra = ?';
                break;
                case 'grasas': 
                    $sql .= ' WHERE grasas = ?';
                break;
            }
        }

          
        //ordenar ASC o DESC
        if (strtoupper($orderDirection) === 'DESC'){ //texto en mayus.
            $orderDirection = 'DESC';
        } else {
            $orderDirection = 'ASC'; //defecto
        }


        //ordenar por campo
        if ($orderBy){
            switch ($orderBy){
                case 'calorias':
                    $sql .= ' ORDER BY calorias ' . $orderDirection;
                break;
                case 'proteinas':
                    $sql .= ' ORDER BY proteinas ' . $orderDirection;
                break;
                case 'ID_grupos':
                    $sql .= ' ORDER BY ID_grupos ' . $orderDirection;
                break;
            }
        }

        //paginación
        if ($pagina !==null && $limite !== null){
            $desplazar = ($pagina - 1) * $limite; //
            $sql .= ' LIMIT ' .(int)$limite . ' OFFSET ' . (int)$desplazar; //asegura num enteros.
        }

        //preparo y ejecuto la consulta
        $query = $this->db->prepare($sql);


        if ($filtro !==null && $valor!==null) {
            $query->execute([$valor]); //si hay valor, lo envía
        } else {
            $query->execute(); //ejecuta la consulta normal
        }

        $alimentos = $query->fetchAll(PDO::FETCH_OBJ);
        return $alimentos;
    }
    
    public function obtenerAlimento($ID_alimentos){
        $query = $this->db->prepare(
            'SELECT alimentos.*, grupos_alimentos.nombre_grupo
            FROM alimentos
            JOIN grupos_alimentos ON alimentos.ID_grupos = grupos_alimentos.ID_grupos
            WHERE alimentos.ID_alimentos = ?');

        $query->execute([$ID_alimentos]);

        $alimento = $query->fetch(PDO::FETCH_OBJ);
        return $alimento;
    }


    public function eliminarAlimento($id){
        $query = $this->db->prepare('DELETE FROM alimentos WHERE ID_alimentos = ? ');
        $query->execute([$id]);
    }

    public function insertarAlimento($nombre_alimento, $ID_grupos, $descripcion_alimento, $calorias, $proteinas, $carbohidratos, $grasas, $fibra, $imagen_alimento){
        $query = $this->db->prepare(
            'INSERT INTO alimentos(nombre_alimento, ID_grupos, descripcion_alimento, calorias, 
            proteinas, carbohidratos, grasas, fibra, imagen_alimento) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)' );
        $query->execute([$nombre_alimento, $ID_grupos, $descripcion_alimento, $calorias, $proteinas, $carbohidratos, $grasas, $fibra, $imagen_alimento]);

        $id= $this->db->lastInsertId();
        return $id;
    }

    public function editarAlimento($nombre_alimento, $ID_grupos, $descripcion_alimento, $calorias, $proteinas, $carbohidratos, $grasas, $fibra, $imagen_alimento, $ID_alimentos){
        $query = $this->db->prepare(
            'UPDATE alimentos 
            SET nombre_alimento = ?, ID_grupos = ?, descripcion_alimento = ?, calorias = ?, proteinas = ?, 
                carbohidratos = ?, grasas = ?, fibra = ?, imagen_alimento = ?  
            WHERE ID_alimentos = ?');
        $query->execute([$nombre_alimento, $ID_grupos, $descripcion_alimento, $calorias, $proteinas, $carbohidratos, $grasas, $fibra, $imagen_alimento, $ID_alimentos]);
    }
}