<?php
    class Subject {
        private $nombre;
        private $id;

        public function __construct($id, $nombre) {
            $this->id = $id;
            $this->nombre = $nombre;
        }

        public function getId() {
            return $this->id;
        }

        public function getName() {
            return $this->nombre;
        }
    }
?>