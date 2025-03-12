<?php

require_once 'app/modelos/config.php';

class gruposModelo{
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

    public function obtenerGrupos(){
        $query = $this->db->prepare ('SELECT * FROM grupos_alimentos');
        $query->execute();

        $grupos_alimentos = $query->fetchAll(PDO::FETCH_OBJ);
        return $grupos_alimentos;
    }

    public function obtenerItemPorGrupo($ID_grupos){
        $query = $this->db->prepare('SELECT * FROM alimentos WHERE ID_grupos= ?');
        $query->execute([$ID_grupos]);

        $alimentos = $query->fetchAll(PDO::FETCH_OBJ);
        return $alimentos;
    }

    //para que siempre se vea el nombre del grupo a la que pertenecen los alimentos.

    public function obtenerIDGrupo($ID_grupos){
        $query = $this->db->prepare('SELECT * FROM grupos_alimentos WHERE ID_grupos = ?');
        $query->execute([$ID_grupos]);

        $grupos_alimentos = $query->fetch(PDO::FETCH_OBJ);
        return $grupos_alimentos;
    }

    //funciones para el admin

    public function insertarGrupo($nombre_grupo, $descripcion_grupo, $imagen_grupo){
        $query = $this->db->prepare('INSERT INTO grupos_alimentos(nombre_grupo, descripcion_grupo, imagen_grupo) VALUES (?, ?, ?)');
        $query->execute([$nombre_grupo, $descripcion_grupo, $imagen_grupo]);

        $ID_grupos = $this->db->lastInsertId();
        return $ID_grupos;
    }

    public function eliminarGrupo($ID_grupos){
        $query = $this->db->prepare('DELETE FROM grupos_alimentos WHERE ID_grupos = ?');
        $query->execute([$ID_grupos]);
    }

    public function actualizarGrupo($ID_grupos, $nombre_grupo, $descripcion_grupo, $imagen_grupo){
        $query = $this->db->prepare(
            'UPDATE grupos_alimentos 
        SET nombre_grupo = ? , descripcion_grupo = ?, imagen_grupo = ? 
        WHERE ID_grupos = ?');
        $query->execute([$nombre_grupo, $descripcion_grupo, $imagen_grupo, $ID_grupos]);
    }
}