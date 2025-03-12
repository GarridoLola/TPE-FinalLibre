<?php

require_once 'app/modelos/config.php';

class usuarioModelo {
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

    public function obtenerUsuario($nombre_usuario){
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE nombre_usuario = ?');
        $query->execute([$nombre_usuario]);

        $usuario = $query->fetch(PDO::FETCH_OBJ);
        return $usuario;
    }
}