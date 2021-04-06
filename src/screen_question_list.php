<?php
include("base.php");

session_start();
$env = parse_ini_file("../.env");
$api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);

function listaPreguntas() {
//codigo function

    $user = unserialize($_SESSION['user']);

    if(isset($_POST['subject'])){
        $idSubject = $_POST['subject'];
        $_SESSION['asignaturaActual'] = $idSubject;
    }
    else {
        $idSubject = $_SESSION['asignaturaActual'];
    }

    $env = parse_ini_file("../.env");

    $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);

    $preguntas = $api->getQuestionsSubject(intval($idSubject));

    foreach($preguntas as $pregunta) {

    if($pregunta->IsValida()) {
        $tema = $api->getTheme($pregunta->getTema());
?>
    <div class="columns is-vcentered">

        <div class="column is-7">
            <div class="column">
                <form action="screen_question.php" method="POST">
                        <input type = "hidden" name = "actualizar" value = "<?php echo $pregunta->getId(); ?>">
                        <button class = "button if-block is-info is-light"><?php echo $pregunta->getEnunciado(); ?></button>
                </form>
            </div>
        </div>
        <div>
            <div class="column">
                <div disabled class = "button card if-block is-info  is-outlined "><?php echo "Tema: ".$tema->getNumero()." | ".$tema->getNombre(); ?></div>
            </div>
        </div>
        <div>
            <div class="column">
                <form action="screen_question_list.php" method="POST">
                        <input type = "hidden" name = "borrar" value = "<?php echo $pregunta->getId(); ?>">
                        <button class = "button if-light is-danger">Borrar</button>
                </form>
            </div>
        </div>

    </div>
<?php
    }
    }
    ?>
    <div class="field is-grouped">
    <a href="screen_teacher.php" class="button is-link is-light">Atrás</a> 
</div>
<?php
}

if(isset($_POST['actualizar'])) {
    echo "cargo pregunta y se la envio a question</br>";
    echo $_POST['actualizar']."</br>";
}
if(isset($_POST['borrar'])) {
    $api->deleteQuestion($_POST['borrar']);
    $_POST['borrar'] = NULL;
}
Base("Lista preguntas", 'listaPreguntas');

?>