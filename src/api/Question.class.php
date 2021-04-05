<?php
    include("Answer.class.php");
    class Question {
        private $enunciado;
        private $tema;
        private $respuestas;
        private $respuestaCorrecta;
        private $id;
        private $invalida;

        public function __construct($id, $enunciado, $tema, array $respuestas, $respuestaCorrecta, $invalida = NULL) {
            $this->enunciado = $enunciado;
            $this->tema = $tema;
            $this->respuestas = $respuestas;
            $this->respuestaCorrecta = $respuestaCorrecta;
            $this->id = $id;
            $this->invalida = $invalida;
        }

        public function IsValida() {
            return $this->invalida?false : true;
        }

        public function getId() {
            return $this->id;
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

        public function setRespuesta(Answer $respuesta) {
            $this->respuestas[$respuesta->getLetra()] = $respuesta;
        }

        public function getRespuestaCorrecta() {
            return $this->respuestaCorrecta;
        }

        public function setRespuestaCorrecta ($newRespuesta) {
            $this->respuestaCorrecta = $newRespuesta->getLetra();
        }

        public function __toString(){

            $pregunta = "Id: $this->id \nEnunciado: $this->enunciado \nTema: $this->tema\n
            Respuesta Correcta: $this->respuestaCorrecta\n";
            foreach($this->respuestas as $respuesta) {
                $pregunta.=$respuesta."\n";
            }

            return $pregunta;
    
        }

    }
?>