<?php 
    class User {
        private $id;
        private $email;
        private $password;
        private $rol; 

        public function __construct($id, $email, $password, $rol) {
            $this->id = $id;
            $this->email = $email;
            $this->password = $password;
            $this->rol = $rol;
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

    }
?>