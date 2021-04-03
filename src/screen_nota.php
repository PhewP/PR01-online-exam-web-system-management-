<?php
session_start();

include("base.php");

function Nota() 
{
    $user = unserialize($_SESSION['user']);

    $env = parse_ini_file("../.env");

    $idExam = $_POST['exam'];

    $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);

    $nota = $api->getMark($user->getId(), $idExam);

?>
    <button class = "button is-light"><?php echo $nota; ?></button>
    <div class="field is-grouped">
        </div>
        <a href="screen_student.php" class="button is-link is-light">Atrás</a> 
    </div>
<?php
}

Base("Nota", 'Nota');
?>