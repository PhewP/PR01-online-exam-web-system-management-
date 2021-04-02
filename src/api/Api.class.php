<?php 

    include("User.class.php");
    include("Question.class.php");

    class Api {
        private static $conexion;
        private static $queryGetUser;
        private static $queryGetSubjects;
        private static $queryCreateQuestion;
        private static $queryCreateAnswer;


        public function __construct($host, $dbname, $user, $pass) {
            try {
                self::$conexion = new PDO("mysql:host=".$host.";dbname=".$dbname, $user, $pass);
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                self::$queryGetUser = self::$conexion->prepare("SELECT * FROM  usuario where email = :email AND password = :password");
                self::$queryGetSubjects = self::$conexion->prepare("SELECT s1.* FROM asignatura s1 
                inner join usuarioasignatura ua on s1.id = ua.id_Asignatura
                inner join usuario us on us.id = ua.id_Usuario and us.id = :id");
                self::$queryCreateQuestion = self::$conexion->prepare("INSERT INTO pregunta (id_tema, nombre) VALUES(:id_tema, :nombre)");
                self::$queryCreateAnswer = self::$conexion->prepare("INSERT INTO respuesta(id_pregunta, nombre, verdadero) VALUES(:id_pregunta, :nombre, :verdadero)");
            } catch(Exception $e) {
                die("Error :".$e->getMessage());
            } 
        }

        public function getSubjects($userId) {
            self::$queryGetSubjects->execute(array('id'=> $userId));
            $subjects = [];

            while($asignatura = self::$queryGetSubjects->fetch()) {
                $subjects[$asignatura['nombre']] = new Subject($asignatura['id'], $asignatura['nombre']);
            }

            return $subjects;

        }

        public function getUser($email, $password) {

            self::$queryGetUser->execute(array('email' => $email, 'password' =>$password));
            $newUser = NULL;

            if(self::$queryGetUser->rowCount() > 0) {
                $user = self::$queryGetUser->fetch();
                $asignaturas = $this->getSubjects($user['id']);
                $newUser = new User($user['id'], $user['email'], $user['password'], $user['rol'], $asignaturas);
            }

            self::$queryGetUser->closeCursor();

            return $newUser;
        }

        public function createQuestion($nombre, $respuestas, $respuestaCorrecta, $tema) {
            
            //query crear pregunta con tema.
            self::$queryCreateQuestion->execute(array('id_tema'=>$tema, 'nombre'=>$nombre));
            // obtener el id de pregunta
            $idPregunta = self::$conexion->lastInsertId();
            
            $newRespuestas = [];
            // query crear respuestas con id pregunta
            // crear objetos respuestas
            foreach($respuestas as $letra => $respuesta) {
                $newRespuestas[$letra] = $this->createAnswer($idPregunta, $respuesta, $letra==$respuestaCorrecta ? true : false, $letra);
            }
            
            // crear objeto pregunta que tiene respuestas
            return new Question($idPregunta, $nombre, $tema, $newRespuestas, $newRespuestas[$respuestaCorrecta]);
            // devolver pregunta.
        }
        
        public function createAnswer($idPregunta, $nombre, $esCorrecta, $letra) {
            self::$queryCreateAnswer->execute(array('id_pregunta'=>$idPregunta, 'nombre'=>$nombre, 'verdadero'=>$esCorrecta));
            $idRespuesta = self::$conexion->lastInsertId();
            $pregunta = new Answer($idRespuesta, $nombre, $letra, $esCorrecta);
            self::$queryCreateAnswer->closeCursor();
            return $pregunta;
        }
    }
?>