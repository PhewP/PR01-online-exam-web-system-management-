<?php 

    include("Subject.class.php");
    class User {
        private $id;
        private $email;
        private $password;
        private $rol; 
        private $asignaturas;

        public function __construct($id, $email, $password, $rol, array $asignaturas) {
            $this->id = $id;
            $this->email = $email;
            $this->password = $password;
            $this->rol = $rol;
            $this->asignaturas = $asignaturas;
        }

        public function getId() {
            return $this->id;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getRol() {
            return $this->rol;
        }

        public function getPassword() {
            return $this->password;
        }

        public function setPassword($password) {
            $this->password = $password;
        }

        public function getAsignaturas() {
            return $this->asignaturas;
        }

        public function setAsignaturas(Subject $asignaturas) {
            $this->asignaturas = $asignaturas;
        }

        public function __toString()
        {
            return "__toString = $this->email - $this->rol";
        }

    }
?>