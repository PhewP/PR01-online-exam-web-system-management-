<?php 

    include("User.class.php");
    include("Exam.class.php");

    class Api {
        private static $conexion;
        private static $queryGetUser;
        private static $queryGetSubjects;
        private static $queryCreateQuestion;
        private static $queryCreateAnswer;
        private static $queryGetThemeSubject;
        private static $queryGetActiveTests;
        private static $queryGetNOTActiveTests;
        private static $queryGetQuestions;
        private static $queryGetPendingTests;


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
                
                self::$queryGetThemeSubject = self::$conexion->prepare("SELECT * from tema WHERE id_asignatura = :id_asignatura");
                
                self::$queryGetActiveTests = self::$conexion->prepare("SELECT e1.* FROM examen e1 
                INNER JOIN usuario u1 ON e1.id_Usuario = u1.id and u1.id = :id where NOW() BETWEEN fecha_ini and fecha_fin");
                
                self::$queryGetNOTActiveTests = self::$conexion->prepare("SELECT e1.* FROM examen e1
                INNER JOIN usuario u2 ON e1.id_Usuario = u2.id and u2.id = :id where fecha_fin <= NOW()");
                
                self::$queryGetQuestions = self::$conexion->prepare("SELECT p.* FROM pregunta p
                INNER JOIN  examenpregunta ep ON p.id = ep.id_Pregunta
                INNER JOIN examen e ON ep.id_Examen = e.id and e.id = :id");
                
                self::$queryGetPendingTests = self::$conexion->prepare("SELECT e1.* FROM examen e1 
                INNER JOIN usuario u1 ON e1.id_Usuario = u1.id and u1.id = :id where fecha_fin >= NOW()");
                
            } catch(Exception $e) {
                die("Error :".$e->getMessage());
            } 
        }

        public function getTemasAsignatura($asignaturaId) {
            $themes = [];
            echo $asignaturaId;
            self::$queryGetThemeSubject->execute(array('id_asignatura' => $asignaturaId));
            while($tema = self::$queryGetThemeSubject->fetch()){
                $themes[$tema['numero']] = new Tema($tema['id'], $tema['nombre'], $tema['numero']);
            }
            return $themes;
        }
        
        public function getSubjects($userId) {
            self::$queryGetSubjects->execute(array('id'=> $userId));
            $subjects = [];

            while($asignatura = self::$queryGetSubjects->fetch()) {
                $temas = $this->getTemasAsignatura($asignatura['id']);
                $subjects[$asignatura['nombre']] = new Subject($asignatura['id'], $asignatura['nombre'], $temas);
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

        public function createQuestion($nombre, $respuestas, $respuestaCorrecta, $temaId) {
            
            //query crear pregunta con tema.
            self::$queryCreateQuestion->execute(array('id_tema'=>$temaId, 'nombre'=>$nombre));
            // obtener el id de pregunta
            $idPregunta = self::$conexion->lastInsertId();
            
            $newRespuestas = [];
            // query crear respuestas con id pregunta
            // crear objetos respuestas
            foreach($respuestas as $letra => $respuesta) {
                $newRespuestas[$letra] = $this->createAnswer($idPregunta, $respuesta, $letra==$respuestaCorrecta ? true : false, $letra);
            }
            
            // crear objeto pregunta que tiene respuestas
            return new Question($idPregunta, $nombre, $temaId, $newRespuestas, $newRespuestas[$respuestaCorrecta]);
            // devolver pregunta.
        }
        
        public function createAnswer($idPregunta, $nombre, $esCorrecta, $letra) {
            self::$queryCreateAnswer->execute(array('id_pregunta'=>$idPregunta, 'nombre'=>$nombre, 'verdadero'=>$esCorrecta));
            $idRespuesta = self::$conexion->lastInsertId();
            $pregunta = new Answer($idRespuesta, $nombre, $letra, $esCorrecta);
            self::$queryCreateAnswer->closeCursor();
            return $pregunta;
        }

        public function getTemasExamen($examenId)
        {
            self::$queryGetQuestions->execute(array('id' => $examenId));
            $temas = [];
            $repetido = true;

            while($tema = self::$queryGetQuestions->fetch())
            {
                foreach($temas as $temaActual)
                {
                    if($tema == $temaActual)
                        $repetido = false;
                }
                if($repetido)
                    $temas[] = $tema;
                
                $repetido = true;
            }
            return $temas;
        }

        public function getPendingTests($userId, $subjectId)
        {
            self::$queryGetPendingTests->execute(array('id'=> $userId));
            $numPreguntas = self::$queryGetUser->rowCount();
            $tema = [];
            $tests = [];

            while($test = self::$queryGetPendingTests->fetch()) {
                $testId = $test['id'];
                self::$queryGetQuestions->execute(array('id' => $testId));
                $tema = $this->getTemasExamen($testId);
                $tests[$test['nombre']] = new Exam($testId, $test['id_Usuario'],
                 $numPreguntas,  $subjectId, $test['nombre'], $tema, $test['descripcion'], $test['fecha_ini'], $test['fecha_fin']);
           
            }
            return $tests;
        }

        public function getActiveTests($userId, $subjectId)
        {
            self::$queryGetActiveTests->execute(array('id'=> $userId));
            $numPreguntas = self::$queryGetUser->rowCount();
            $tema = [];
            $tests = [];

            while($test = self::$queryGetActiveTests->fetch()) {
                $testId = $test['id'];
                self::$queryGetQuestions->execute(array('id' => $testId));
                $tema = $this->getTemasExamen($testId);
                $tests[$test['nombre']] = new Exam($testId, $test['id_Usuario'],
                 $numPreguntas,  $subjectId, $test['nombre'], $tema, $test['descripcion'], $test['fecha_ini'], $test['fecha_fin']);
           
            }
            return $tests;
        }

        public function getNOTActiveTests($userId, $subjectId)
        {
            self::$queryGetNOTActiveTests->execute(array('id'=> $userId));
            $numPreguntas = self::$queryGetUser->rowCount();
            $tema = [];
            $tests = [];

            while($test = self::$queryGetNOTActiveTests->fetch()) {
                $testId = $test['id'];
                self::$queryGetQuestions->execute(array('id' => $testId));
                $tema = $this->getTemasExamen($testId);
                $tests[$test['nombre']] = new Exam($testId, $test['id_Usuario'],
                 $numPreguntas,  $subjectId, $test['nombre'], $tema, $test['descripcion'], $test['fecha_ini'], $test['fecha_fin']);

            }
            return $tests;
        }
    }
?>