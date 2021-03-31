<?php
    class Answer {
        private $idPregunta;
        private $descripcion;
        private $esCorrecta;
        private $letra;

        public function __construct($idPregunta, $descripcion, $letra, $esCorrecta=false) {
            $this->idPregunta = $idPregunta;
            $this->descripcion = $descripcion;
            $this->esCorrecta = $esCorrecta;
            $this->letra = $letra;
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
    }
?>