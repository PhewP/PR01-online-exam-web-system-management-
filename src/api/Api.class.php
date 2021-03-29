<?php 

    include("User.class.php");

    class Api {
        private static $conexion;
        private static $queryGetUser;


        public function __construct($host, $dbname, $user, $pass) {
            try {
                self::$conexion = new PDO("mysql:host=".$host.";dbname=".$dbname, $user, $pass);
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                self::$queryGetUser = self::$conexion->prepare("SELECT * FROM  usuario where email = :email AND password = :password");

            } catch(Exception $e) {
                die("Error :".$e->getMessage());
            } finally {
                self::$conexion = NULL;
            }


        }

        public function getUser($email, $password) {

            self::$queryGetUser->execute(array('email' => $email, 'password' =>$password));

            if(self::$queryGetUser->rowCount() > 0) {
                $user = self::$queryGetUser->fetch();

                return new User($user['id'], $user['email'], $user['password'], $user['rol']);
            }

            self::$queryGetUser->closeCursor();

            return null;
        }
    }
?>