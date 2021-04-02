<?php 
    class Tema {
        private $id;
        private $nombre;
        private $numero;

        public function __construct($id , $nombre, $numero) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->numero = $numero;
        }

        public function getId(){
            return $this->id;
        }

        public function  getNombre() {
            return $this->nombre;
        }

        public function getNumero() {
            return $this->number;
        }

        public function __toString(){
            return "Id Tema: $this->id \nNombre Tema: $this->nombre \nNumero tema: $this->numbero";
        }
    }
?>