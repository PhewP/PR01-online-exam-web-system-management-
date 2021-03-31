<?php

    include("Question.class.php");
    class Exam {

        private $titulo;
        private $descripcion;
        private $temas = [];
        private $alumnos = [];
        private $preguntas = [];
        private $numPreguntas;
        private $fecha_inicio;
        private $fecha_fin;
        private $profesor;
        private $asignatura;
        private $id;

        public function __construct($profesor, $numPreguntas, $asignatura, $titulo, $temas, $descripcion, $fecha_inicio, $fecha_fin) {
            $this->profesor = $profesor;
            $this->$numPreguntas = $numPreguntas;
            $this->asignatura = $asignatura;
            $this->titulo = $titulo;
            $this->temas = $temas;
            $this->descripcion = $descripcion;
            $this->fecha_fin = $fecha_inicio;
            $this->fecha_fin = $fecha_fin;
            $this->preguntas = $this->selectPreguntas();
            $this->alumnos = $this->selectAlumnos();
        }

        public function getAsignatura() {
            return $this->asignatura;
        }

        public function getFechaInicio() {
            return $this->fecha_inicio;
        }

        public function getFechaFin() {
            return $this->fecha_fin;
        }

        public function getTitulo() {
            return $this->titulo;
        }

        public function setTitulo($newTitulo){
            return $this-> $newTitulo;
        }

        public function getDescripcion() {
            return $this->descripcion;
        }

        public function setDescripcion($newDescripcion) {
            $this->descripcion = $newDescripcion;
        }

        public function getTemas() {
            return $this->temas;
        }

        public function setTemas($newTemas) {
            $this->temas = $newTemas;
        }

        public function getAlumnos() {
            return $this->alumnos;
        }

        public function setAlumnos($newAlumnos) {
            $this->alumnos = $newAlumnos;
        }

        public function getId() {
            return $this->id;
        }

        public function getProfesor() {
            return $this->profesor;
        }

        public function getNumPreguntas() {
            return $this->numPreguntas;
        }

        public function getPreguntas() {
            return $this->preguntas;
        }

        public function selectPreguntas() {
            // create n objetos preguntas random y asignarlos a preguntas/
            return NULL;
        }

        public function selectAlumnos() {
            //Seleccionar todos los alumnos de esa asignatura
            return NULL;
        }
    }
?>