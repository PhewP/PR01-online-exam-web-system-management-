<?php
    class Question {
        private $enunciado;
        private $tema;
        private $respuestas;
        private $respuestaCorrecta;

        public function __construct($enunciado, $tema, $respuestas, $respuestaCorrecta) {
            $this->enunciado = $enunciado;
            $this->tema = $tema;
            $this->respuestas = $respuestas;
            $this->respuestaCorrecta = $respuestaCorrecta;
        }

        public function getEnunciado() {
            return $this->enunciado;
        }

        public function setEnunciado($newEnunciado) {
            $this->enunciado = $newEnunciado;
        }

        public function getTema() {
            return $this->tema;
        }

        public function setTema($newTema) {
            $this->tema = $newTema;
        }

        public function  getRespuestas() {
            return $this->respuestas;
        }

        public function setRespuestas($newRespuestas) {
            $this->respuestas = $newRespuestas;
        }

        public function getRespuestaCorrecta() {
            return $this->respuestaCorrecta;
        }

        public function setRespuestaCorrecta($newRespuestaCorrecta) {
            $this->respuestaCorrecta = $newRespuestaCorrecta;
        }

    }
?>