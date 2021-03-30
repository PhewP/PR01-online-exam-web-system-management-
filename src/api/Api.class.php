<?php 

    include("User.class.php");

    class Api {
        private static $conexion;
        private static $queryGetUser;
        private static $queryGetSubjects;


        public function __construct($host, $dbname, $user, $pass) {
            try {
                self::$conexion = new PDO("mysql:host=".$host.";dbname=".$dbname, $user, $pass);
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                self::$queryGetUser = self::$conexion->prepare("SELECT * FROM  usuario where email = :email AND password = :password");
                self::$queryGetSubjects = self::$conexion->prepare("SELECT s1.* FROM asignatura s1 
                inner join usuarioasignatura ua on s1.id = ua.id_Asignatura
                inner join usuario us on us.id = ua.id_Usuario and us.id = :id");

            } catch(Exception $e) {
                die("Error :".$e->getMessage());
            } finally {
                self::$conexion = NULL;
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
    }
?>