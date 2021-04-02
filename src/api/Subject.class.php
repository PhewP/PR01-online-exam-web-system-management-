<?php

    include("Tema.class.php");
    class Subject {
        private $nombre;
        private $id;
        private $temas;

        public function __construct($id, $nombre, array $temas) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->temas = $temas;
        }

        public function getId() {
            return $this->id;
        }

        public function getName() {
            return $this->nombre;
        }

        public function getTemas() {
            return $this->temas;
        }

        public function __toString(){

            $asignatura = "Id Asignatura: $this->id \n Nombre Asignatura: $this->nombre\n";

            foreach($this->temas as $tema){
                $asignatura.=$tema."\n";
            }

            return $asignatura;
            
        }
    }
?>