<?php 
include("base.php");
session_start();

function question () {
    $actualizar = false; 

    if(isset($_POST['actualizar'])) {
        $actualizar = true;
    
        $env = parse_ini_file("../.env");
      
        $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);

        $UQuestion  = $api->getQuestionById($_POST['actualizar']);
        $respuestas = $UQuestion->getRespuestas();

        $i = 0;
        $letras = array("A", "B", "C", "D");
        $letraCorrecta = NULL;
        $idRespuestas = [];
        foreach($respuestas as $respuesta)
        {
            $Urespuesta[] = $respuesta->getDescripcion();
            if($respuesta->getEsCorrecta()){
                $letraCorrecta = $letras[$i];
            }
            $i++;

            $idRespuestas[] = $respuesta->getId();
        }

        $_SESSION['idRespuestasActualizar'] = serialize($idRespuestas);
        $_SESSION['idPreguntaActual'] = $UQuestion->getId();
        
        // Traerme preguntas
    
    
    
        // Traerme el tema;
    }

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
            <textarea class="textarea" placeholder="Escriba el enunciado de la pregunta" 
            name="enunciado" required><?php if($actualizar){echo $UQuestion->getEnunciado();}?></textarea>
            </div>
        </div>
        <div class="field">
            <label class="label">Respuesta A</label>
            <div class="control">
                <input class="input" value="<?php if($actualizar){echo $Urespuesta[0];}?>"
                type="text" placeholder="Inserte una respuesta" name="respuestaA" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Respuesta B</label>
            <div class="control">
                <input value="<?php if($actualizar){echo $Urespuesta[1];}?>"
                class="input" type="text" placeholder="Inserte una respuesta" name="respuestaB" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Respuesta C</label>
            <div class="control">
                <input value="<?php if($actualizar){echo $Urespuesta[2];}?>"

                class="input" type="text" placeholder="Inserte una respuesta" name="respuestaC" required>
            </div>
        </div>
        <div class="field">
            <label class="label">Respuesta D</label>
            <div class="control">
                <input 
                value="<?php if($actualizar){echo $Urespuesta[3];}?>"
                class="input" type="text" placeholder="Inserte una respuesta" name="respuestaD" required>
            </div>
        </div>

        <div class="field">
        <label class="label">Respuesta Correcta</label>
        <div class="control">
            <div class="select">
            <select name="respuestaCorrecta" class="has-text-centered" required>
                <option disabled>Seleccione una opción</option>
                <option value="A" <?php 
                if($actualizar && $letraCorrecta == "A"){ echo "Selected"; }?>>A</option>
                <option value="B"
                <?php 
                if($actualizar && $letraCorrecta == "B"){ echo"Selected";}?>
                >B</option>
                <option value="C"
                <?php 
                if($actualizar && $letraCorrecta == "C"){ echo "Selected"; }?>>C</option>
                <option value="D"
                <?php 
                if($actualizar && $letraCorrecta == "D"){ echo"Selected"; }?>>D</option>
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
                <option 
                    <?php 
                        if($actualizar){
                            if($tema->getId() == $UQuestion->getTema())
                                echo "Selected";
                        }
                    ?> 
                    value="<?php echo $tema->getId()?>">Tema <?php echo " ".$tema->getNumero().": ".$tema->getNombre()?></option>
                <?php 
                    }
                ?>
            </select>
            </div>
        </div>
        </div>
        <div class="field is-grouped">
            <div class="control">
                <input type="submit" class="button is-link" name="crear" value=<?php echo $actualizar ? "Actualizar":"Crear"?> >
            </div>
            <?php
                if($actualizar)
                {?>
                    <a href="screen_question_list.php" class="button is-link is-light">Atrás</a> 
                <?php
                }
                else {
                    ?>
                    <a href="screen_teacher.php" class="button is-link is-light">Atrás</a> 
                    <?php
                }
            ?>
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
function preguntaActualizada(){
?>
    <div class="field is-grouped">
            <a href="screen_question_list.php" class="button is-link is-light">Atrás</a> 
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
    $enunciado = $_POST['enunciado'];
    $respuestaCorrecta = $_POST['respuestaCorrecta'];
    $idTema = $_POST['tema'];

    if($_POST['crear'] == 'Crear') {

        $api->createQuestion($_POST['enunciado'],$respuestas, $_POST['respuestaCorrecta'], intval($_POST['tema']));
        base("Pregunta Creada", 'preguntaCreada');
    }
    else if($_POST['crear'] == 'Actualizar'){
        $idRespuestas = unserialize($_SESSION['idRespuestasActualizar']);
        $api->updateQuestion($_SESSION['idPreguntaActual'], $enunciado, $idRespuestas, $respuestas, $respuestaCorrecta, intval($_POST['tema']));
        base("Pregunta Actualizada", 'preguntaActualizada');
    }
}
else {
    base(isset($_POST['actualizar'])?'Actualiza Pregunta':'Crear Pregunta', 'question');
}



?>
