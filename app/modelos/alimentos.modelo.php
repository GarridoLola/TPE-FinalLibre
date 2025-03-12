<?php 

require_once 'app/modelos/config.php';

class alimentosModelo {
    private $db;

    public function __construct(){
        $this->db = new PDO(
            "mysql:host=".MYSQL_HOST . ";dbname=" . MYSQL_DB. "; charset=utf8", MYSQL_USER, MYSQL_PASS);
            $this->deploy();
    }
    private function deploy (){
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if (count($tables) == 0) {
            $sql = <<<END

            END;
            $this->db->query($sql);
        }
    }
        public function obtenerAlimento(){
            $query = $this->db->prepare(
                'SELECT alimentos.*, grupos_alimentos.nombre_grupo
                FROM alimentos
                JOIN grupos_alimentos ON alimentos.ID_grupos = grupos_alimentos.ID_grupos');
            $query->execute();

            $alimentos = $query->fetchAll(PDO::FETCH_OBJ);
            return $alimentos;
        }

        public function obtenerAlimentoDetalle($ID_alimentos){
            $query = $this->db->prepare(
                'SELECT alimentos.*, grupos_alimentos.nombre_grupo
                FROM alimentos
                JOIN grupos_alimentos ON alimentos.ID_grupos = grupos_alimentos.ID_grupos
                WHERE alimentos.ID_alimentos = ?');

            $query->execute([$ID_alimentos]);

            $alimento = $query->fetch(PDO::FETCH_OBJ);
            return $alimento;
        }

        //funciones para admin.


        public function insertarAlimento($nombre_alimento, $ID_grupos, $descripcion_alimento, $calorias, $proteinas, $carbohidratos, $grasas, $fibra, $imagen_alimento){
            $query = $this->db->prepare(
                'INSERT INTO alimentos(nombre_alimento, ID_grupos, descripcion_alimento, calorias, 
                proteinas, carbohidratos, grasas, fibra, imagen_alimento) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)' );
            $query->execute([$nombre_alimento, $ID_grupos, $descripcion_alimento, $calorias, $proteinas, $carbohidratos, $grasas, $fibra, $imagen_alimento]);

            $ID_alimento = $this->db->lastInsertId();
            return $ID_alimento;
        }   


        public function eliminarAlimento($ID_alimentos){
            $query = $this->db->prepare('DELETE FROM alimentos WHERE ID_alimentos = ?');
            $query->execute([$ID_alimentos]);
        }

        public function actualizarAlimento($ID_alimentos, $nombre_alimento, $ID_grupos, $descripcion_alimento, $calorias, $proteinas, $carbohidratos, $grasas, $fibra, $imagen_alimento){
            $query = $this->db->prepare(
                'UPDATE alimentos 
                SET nombre_alimento = ?, ID_grupos = ?, descripcion_alimento = ?, calorias = ?, proteinas = ?, 
                    carbohidratos = ?, grasas = ?, fibra = ?, imagen_alimento = ?  
                WHERE ID_alimentos = ?');
            $query->execute([$nombre_alimento, $ID_grupos, $descripcion_alimento, $calorias, $proteinas, $carbohidratos, $grasas, $fibra, $imagen_alimento, $ID_alimentos]);
        }
}   