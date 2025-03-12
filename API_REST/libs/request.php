<?php
    class Request {
        public $body = null; # {nombre: 'Saludar, descripcion 'Saludar a todos'}
        public $params = null; #api/alimentos/:id
        public $query = null; #

        public function __construct(){
            try {
                #file_get_contents('php://input') lee el body del request
                $this->body = json_decode(file_get_contents('php://input'));
            }
            catch (Exception $e){
                $this->body = null;
            }
            $this->query = (object) $_GET;
        }
    }   