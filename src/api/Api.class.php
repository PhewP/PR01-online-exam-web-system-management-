<?php 

    include("User.class.php");
    include("Exam.class.php");

    class Api {
        private static $conexion;
        private static $queryGetUser;
        private static $queryGetSubjects;
        private static $queryCreateQuestion;
        private static $queryGetQuestionTheme;
        private static $queryCreateAnswer;
        private static $queryGetAnswers;
        private static $queryGetThemeSubject;
        private static $queryGetActiveTests;
        private static $queryGetNOTActiveTests;
        private static $queryGetQuestions;
        private static $queryGetPendingTests;
        private static $queryCreateExam;
        private static $queryCreateExamQuestion;
        private static $queryGetAlumnsSubject;
        private static $queryCreateAlumnExamn;
        private static $queryGetMark;
        private static $queryGetUsersExams;
        private static $queryGetActiveTestsStudent;
        private static $queryGetNOTActiveTestsStudent;
        private static $queryGetPendingTestsStudent;
        private static $querySetNota;
        private static $queryGetInfoExamen;
        private static $queryGetTituloPregunta;


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
                INNER JOIN usuario u1 ON e1.id_Usuario = u1.id and u1.id = :id where NOW() BETWEEN fecha_ini and fecha_fin and e1.id_Asignatura = :id_a");
              
                self::$queryGetNOTActiveTests = self::$conexion->prepare("SELECT e2.* FROM examen e2
                INNER JOIN usuario u2 ON e2.id_Usuario = u2.id and u2.id = :id where fecha_fin <= NOW() and e2.id_Asignatura = :id_a");

                self::$queryGetActiveTestsStudent = self::$conexion->prepare("SELECT e1.* FROM examen e1 where NOW() BETWEEN fecha_ini and fecha_fin and e1.id_Asignatura = :id_a");

                self::$queryGetNOTActiveTestsStudent = self::$conexion->prepare("SELECT e2.* FROM examen e2 where fecha_fin <= NOW() and e2.id_Asignatura = :id_a");
                self::$queryGetPendingTestsStudent = self::$conexion->prepare("SELECT e2.* FROM examen e2 where fecha_fin >= NOW() and e2.id_Asignatura = :id_a");

                self::$queryGetQuestions = self::$conexion->prepare("SELECT p.* FROM pregunta p
                INNER JOIN  examenpregunta ep ON p.id = ep.id_Pregunta
                INNER JOIN examen e ON ep.id_Examen = e.id and e.id = :id");
                
                self::$queryGetPendingTests = self::$conexion->prepare("SELECT e1.* FROM examen e1 
                INNER JOIN usuario u1 ON e1.id_Usuario = u1.id and u1.id = :id where fecha_fin >= NOW() and e1.id_Asignatura = :id_a");
              
                self::$queryCreateExam = self::$conexion->prepare("INSERT INTO examen(id_usuario, 
                                                                    id_asignatura, fecha_ini, fecha_fin, nombre, descripcion) VALUES(:id_usuario, 
                                                                    :id_asignatura, :fecha_ini, :fecha_fin, :nombre, :descripcion)");
                
                self::$queryCreateExamQuestion = self::$conexion->prepare("INSERT INTO examenpregunta(id_examen, id_pregunta) VALUES (:id_examen, :id_pregunta)");                                                

                self::$queryGetQuestionTheme = self::$conexion->prepare("SELECT * FROM pregunta where id_tema = :id_tema");
                self::$queryGetAnswers = self::$conexion->prepare("SELECT * from respuesta where id_pregunta = :id_pregunta");
                self::$queryGetAlumnsSubject = self::$conexion->prepare("SELECT u1.* FROM usuario u1
                INNER JOIN usuarioasignatura ua1 ON u1.id = ua1.id_Usuario 
                WHERE ua1.id_Asignatura = :id_asignatura AND u1.rol = 'estudiante' ");

                self::$queryCreateAlumnExamn = self::$conexion->prepare("INSERT INTO usuarioexamen(id_usuario, id_examen) VALUES(:id_usuario, :id_examen)");

                self::$queryGetMark = self::$conexion->prepare("SELECT nota FROM usuarioexamen ue WHERE ue.id_Usuario = :u_id and ue.id_Examen = :e_id");

                self::$queryGetUsersExams = self::$conexion->prepare("SELECT * FROM  usuarioexamen WHERE id_examen = :id_examen");
                
                self::$querySetNota = self::$conexion->prepare("UPDATE usuarioexamen SET nota = :nota where id_Usuario = :u_id and id_Examen = :e_id");
                self::$queryGetInfoExamen = self::$conexion->prepare("SELECT e.* FROM examen e where e.id = :id");
            
                self::$queryGetTituloPregunta = self::$conexion->prepare("SELECT p.* FROM pregunta p where p.id = :id");
            } catch(Exception $e) {
                die("Error :".$e->getMessage());
            } 
        }

        public function getTemasAsignatura($asignaturaId) {
            $themes = [];
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
                $newRespuestas[$letra] = $this->createAnswer($idPregunta, $respuesta, $letra==$respuestaCorrecta ? 1 : 0, $letra);
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

            while($pregunta = self::$queryGetQuestions->fetch())
            {
                $temas[] = $pregunta['id_Tema'];
            }

            array_unique($temas);
            
            return $temas;
        }

        public function getPendingTests($userId, $subjectId)
        {
            self::$queryGetPendingTests->execute(array('id'=> $userId, 'id_a' => $subjectId));
            $numPreguntas = self::$queryGetQuestions->rowCount();
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
            self::$queryGetActiveTests->execute(array('id'=> $userId, 'id_a' => $subjectId));
            $numPreguntas = self::$queryGetQuestions->rowCount();
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
            self::$queryGetNOTActiveTests->execute(array('id'=> $userId, 'id_a' => $subjectId));
            $numPreguntas = self::$queryGetQuestions->rowCount();
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

        public function getActiveTestsStudent($subjectId)
        {
            self::$queryGetActiveTestsStudent->execute(array('id_a' => $subjectId));
            $numPreguntas = self::$queryGetQuestions->rowCount();
            $tema = [];
            $tests = [];

            while($test = self::$queryGetActiveTestsStudent->fetch()) {
                $testId = $test['id'];
                self::$queryGetQuestions->execute(array('id' => $testId));
                $tema = $this->getTemasExamen($testId);
                $tests[$test['nombre']] = new Exam($testId, $test['id_Usuario'],
                 $numPreguntas,  $subjectId, $test['nombre'], $tema, $test['descripcion'], $test['fecha_ini'], $test['fecha_fin']);
           
            }
            return $tests;
        }

        public function getNOTActiveTestsStudent($subjectId)
        {
            self::$queryGetNOTActiveTestsStudent->execute(array('id_a' => $subjectId));
            $numPreguntas = self::$queryGetQuestions->rowCount();
            $tema = [];
            $tests = [];

            while($test = self::$queryGetNOTActiveTestsStudent->fetch()) {
                $testId = $test['id'];
                self::$queryGetQuestions->execute(array('id' => $testId));
                $tema = $this->getTemasExamen($testId);
                $tests[$test['nombre']] = new Exam($testId, $test['id_Usuario'],
                 $numPreguntas,  $subjectId, $test['nombre'], $tema, $test['descripcion'], $test['fecha_ini'], $test['fecha_fin']);

            }
            return $tests;
        }

        public function getPendingTestsStudent($subjectId)
        {
            self::$queryGetPendingTestsStudent->execute(array('id_a' => $subjectId));
            $numPreguntas = self::$queryGetQuestions->rowCount();
            $tema = [];
            $tests = [];

            while($test = self::$queryGetPendingTestsStudent->fetch()) {
                $testId = $test['id'];
                self::$queryGetQuestions->execute(array('id' => $testId));
                $tema = $this->getTemasExamen($testId);
                $tests[$test['nombre']] = new Exam($testId, $test['id_Usuario'],
                 $numPreguntas,  $subjectId, $test['nombre'], $tema, $test['descripcion'], $test['fecha_ini'], $test['fecha_fin']);
           
            }
            return $tests;
        }

        public function getQuestionsTheme($temaId) {
            $preguntas = [];
            $respuestaCorrecta = NULL;

            self::$queryGetQuestionTheme->execute(array('id_tema'=>$temaId));

            while($pregunta = self::$queryGetQuestionTheme->fetch()) {
                $idPregunta = $pregunta['id'];
                $respuestas = [];
                self::$queryGetAnswers->execute(array('id_pregunta'=>$idPregunta));
                while($respuesta = self::$queryGetAnswers->fetch()){
                    if($respuesta['verdadero']){
                        $respuestaCorrecta = new Answer($respuesta['id'], $respuesta['nombre'], NULL, true);
                    }
                    $respuestas[] = new Answer($respuesta['id'], $respuesta['nombre'], NULL);  
                }
                $preguntas[] = new Question($pregunta['id'], $pregunta['nombre'], $temaId, $respuestas, $respuestaCorrecta);
            }

            return $preguntas;
        }

        public function createExam($userId, $subjectId, $fechaIni, $fechaFin, $nombre, $descripcion, $temasId, $numPreguntas) {
            $preguntasTema = [];
            foreach($temasId as $temaId) {
                $preguntasTema = array_merge($preguntasTema, $this->getQuestionsTheme(intval($temaId)));
            }
            shuffle($preguntasTema);
            $preguntasTema = array_slice($preguntasTema, 0, $numPreguntas);

            self::$queryCreateExam->execute(array('id_usuario' => $userId, 
            'id_asignatura'=>$subjectId, 'fecha_ini'=>$fechaIni, 'fecha_fin'=>$fechaFin, 
            'nombre'=>$nombre, 'descripcion'=>$descripcion));
            $idExamen = self::$conexion->lastInsertId();

            $res = self::$conexion->query("SELECT * FROM asignatura WHERE id = $subjectId");
            $asignatura = $res->fetch();
            $res ->closeCursor();
            $res = self::$conexion->query("SELECT * FROM tema WHERE id_asignatura = $subjectId");

            while($tema = $res->fetch()){
                $temas[$tema['numero']] = new Tema($tema['id'], $tema['nombre'], $tema['numero']);
            }

    
            $newAsignatura = new Subject($asignatura['id'], $asignatura['nombre'], $temas);


            $newExamen = new Exam($idExamen, $userId, $numPreguntas, $newAsignatura, $nombre, $temas, $descripcion, $fechaIni, $fechaFin);

            foreach($preguntasTema as $pregunta){
                self::$queryCreateExamQuestion->execute(array('id_examen'=>$idExamen, 'id_pregunta'=>$pregunta->getId()));
            }

            return $newExamen;

        }
        
        public function getAlumnsSubject($subjectId) {
            $alumns = [];

            self::$queryGetAlumnsSubject->execute(array('id_asignatura' =>$subjectId));

            while($alumn = self::$queryGetAlumnsSubject->fetch()) {
                $asignaturas = $this->getSubjects($alumn["id"]);
                $alumns[$alumn['nombre']] = new User($alumn["id"], $alumn["email"], 
                                            $alumn["password"], $alumn["rol"], $asignaturas);
            }

            return $alumns;
        }

        public function createAlumnExamn($userId, $examId) {
            self::$queryCreateAlumnExamn->execute(array('id_usuario'=>$userId, 'id_examen'=>$examId));
        }

        public function getMark($userId, $examId)
        {
            self::$queryGetMark->execute(array('u_id'=> $userId, 'e_id' => $examId));
            $nota = self::$queryGetMark->fetch();
            return $nota['nota'];
        }

        public function setNota($nota, $userId, $examId)
        {
            self::$querySetNota->execute(array('nota' => $nota, 'u_id' => $userId, 'e_id' => $examId));
        }

        public function getPreguntas($examenId)
        {
            self::$queryGetQuestions->execute(array('id' => $examenId));
            $preguntas = [];

            while($pregunta = self::$queryGetQuestions->fetch())
            {
                $respuestas = $this->getRespuestas($pregunta['id']);
                $respuestaCorrecta = NULL;
                foreach($respuestas as $respuesta)
                {
                    if($respuesta->getEsCorrecta()) { $respuestaCorrecta = $respuesta; }
                }
                
                $preguntas[$pregunta['nombre']] = new Question($pregunta['id'], $pregunta['nombre'], $pregunta['id_Tema'], $respuestas, $respuestaCorrecta);
            }

            return $preguntas;
        }

        public function getRespuestas($idPregunta)
        {
            self::$queryGetAnswers->execute(array('id_pregunta' => $idPregunta));
            $respuestas = [];

            $letra = array('A', 'B', 'C', 'D');

            while($respuesta = self::$queryGetAnswers->fetch())
            {
                $respuestas[$respuesta['nombre']] = new Answer($respuesta['id'], $respuesta['nombre'], $letra, $respuesta['verdadero']); 
            }

            return $respuestas;
        }

        public function getAllMarks($examId) {
            self::$queryGetUsersExams->execute(array('id_examen'=>$examId));

            $notas = [];

            while($examen = self::$queryGetUsersExams->fetch()){
                $notas[] = $examen['nota'];
            }
            return $notas;
        }

        public function getDescription($examId)
        {
            self::$queryGetInfoExamen->execute(array('id' => $examId));
            $descripcion = self::$queryGetInfoExamen->fetch();
            return $descripcion['descripcion'];
        }

        public function getHoraComienzo($examId)
        {
            self::$queryGetInfoExamen->execute(array('id' => $examId));
            $fechaini = self::$queryGetInfoExamen->fetch();
            return $fechaini['fecha_ini'];
        }

        public function getHoraFin($examId)
        {
            self::$queryGetInfoExamen->execute(array('id' => $examId));
            $fechafin = self::$queryGetInfoExamen->fetch();
            return $fechafin['fecha_fin'];
        }

        public function getTituloPregunta($idPregunta)
        {
            self::$queryGetTituloPregunta->execute(array('id' => $idPregunta));
            $titulo = self::$queryGetTituloPregunta->fetch();
            return $titulo['nombre'];
        }
    }
?>