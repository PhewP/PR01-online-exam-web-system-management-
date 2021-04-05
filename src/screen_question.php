<?php 
include("base.php");

function question () {

session_start();

if(isset($POST['idSubject'])) {
    $idAsignatura = intval($_POST['idSubject']);
    $_SESSION['asignaturaActual'] = $idAsignatura;
}
else {    
    $idAsignatura = $_SESSION['asignaturaActual'];
}
$asignatura = NULL;
$user = unserialize($_SESSION['user']);

$userAsignaturas = $user->getAsignaturas();
foreach($userAsignaturas as $userAsignatura) {
      if($userAsignatura->getId() == $idAsignatura)
        $asignatura = $userAsignatura;
}
$temas = $asignatura->getTemas();
?>

<form action="screen_question.php" method="POST" >
        <div class="field">
            <label class="label">Enunciado</label>
            <div class="control">
            <textarea class="textarea" placeholder="Escriba el enunciado de la pregunta" name="enunciado" required></textarea>
            </div>
        </div>
        <div class="field">
            <label class="label">Respuesta A</label>
            <div class="control">
                <input class="input" type="text" placeholder="Inserte una respuesta" name="respuestaA" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Respuesta B</label>
            <div class="control">
                <input class="input" type="text" placeholder="Inserte una respuesta" name="respuestaB" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Respuesta C</label>
            <div class="control">
                <input class="input" type="text" placeholder="Inserte una respuesta" name="respuestaC" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Respuesta D</label>
            <div class="control">
                <input class="input" type="text" placeholder="Inserte una respuesta" name="respuestaD" required>
            </div>
        </div>

        <div class="field">
        <label class="label">Respuesta Correcta</label>
        <div class="control">
            <div class="select">
            <select name="respuestaCorrecta" class="has-text-centered" required>
                <option disabled>Seleccione una opción</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
            </div>
        </div>
        </div>
        <div class="field">
        <label class="label">Tema</label>
        <div class="control">
            <div class="select">
            <select name="tema" class="has-text-centered" required>
                <option disabled>Seleccione un tema</option>
                <?php
                    foreach($temas as $tema) {
                ?>
                <option value="<?php echo $tema->getId()?>">Tema <?php echo " ".$tema->getNumero().": ".$tema->getNombre()?></option>
                <?php 
                    }
                ?>
            </select>
            </div>
        </div>
        </div>
        <div class="field is-grouped">
            <div class="control">
                <input type="submit" class="button is-link" name="crear" value="Crear">
            </div>
            <a href="screen_teacher.php" class="button is-link is-light">Atrás</a> 
        </div>
        </form>

<?php

}

function preguntaCreada(){
?>
    <div class="field is-grouped">
            <div class="control">
            <a href="screen_question.php" class="button is-link">Crear Otra</a> 

            </div>
            <a href="login.php" class="button is-link is-light">Atrás</a> 
    </div>
<?php
}

if(isset($_POST['crear'])) {
    $env = parse_ini_file("../.env");
  
    $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);
    
    $respuestas['A'] = $_POST['respuestaA'];
    $respuestas['B'] = $_POST['respuestaB'];
    $respuestas['C'] = $_POST['respuestaC'];
    $respuestas['D'] = $_POST['respuestaD'];
    $api->createQuestion($_POST['enunciado'],$respuestas, $_POST['respuestaCorrecta'], intval($_POST['tema']));
    base("Pregunta Creada", 'preguntaCreada');
}
else {
    base('Crear Pregunta', 'question');
}



?>
