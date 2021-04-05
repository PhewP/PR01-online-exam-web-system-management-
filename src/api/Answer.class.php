<?php
    class Answer {
        private $descripcion;
        private $esCorrecta;
        private $letra;
        private $id;

        public function __construct($id, $descripcion, $letra, $esCorrecta=false) {
            $this->id = $id;
            $this->descripcion = $descripcion;
            $this->esCorrecta = $esCorrecta;
            $this->letra = $letra;
        }

        public function getId() {
            return $this->id;
        }

        public function getIdPregunta() {
            return $this->idPregunta;
        }

        public function getLetra() {
            return $this->letra;
        }

        public function setLetra($newLetra) {
            $this->letra = $newLetra;
        }

        public function getDescripcion() {
            return $this->descripcion;
        }

        public function setDescripcion($descripcion) {
            $this->descripcion = $descripcion;
        }

        public function getEscorrecta() {
            return $this->esCorrecta;
        }

        public function __toString() {

            return "ID Respuesta: $this->id \nEnunciado: $this->descripcion \n
            Escorrecta: $this->esCorrecta \nLetra: $this->letra";
  
        }
    }
?>