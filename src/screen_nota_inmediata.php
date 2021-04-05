<?php
session_start();

include("base.php");

function Nota() 
{
    $user = unserialize($_SESSION['user']);

    $env = parse_ini_file("../.env");

    $idExam = $_SESSION['idExamen'];

    $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);

    $nota = $api->getMark($user->getId(), $idExam);

    $arrayLetras = [0=>'A', 1=>'B', 2=>'C', 3=>'D'];

    $j = 0;
    ?>
    <h2 class="title"><?php echo $nota; ?></h1>
    <?php
    echo "<hr>"; 
    ?>
    <h1 class="title">Respuestas erroneas</h1>
    <div class="field">
    <?php

    echo "ATENCION: En verde se mostrara la respuesta correcta.";

    echo "</br>";
    echo "</br>";


    $preguntas = $api->getPreguntas($idExam);

    foreach($preguntas as $pregunta)
    {
        $j = 0;
        $respuestas = $api->getRespuestas($pregunta->getId());
        $api->getExamenPreguntaId($pregunta->getId(), $idExam);
        $infoRespuesta = $api->getRespuestaUsuario($user->getId(), $idExam, $pregunta->getId());
        // if($api->getRespuestaUsuario($user->getId(), $idExam, $pregunta->getId()) == 1)
        if($infoRespuesta['idRespuesta'] == 1)
        {
            echo "Usted no ha dado respuesta a la siguiente pregunta:";
            echo "</br>";
        }
        ?><b type = "text" name = "correcto" style="color: black;"><?php echo $api->getTituloPregunta($pregunta->getId()); ?></b><?php
        echo "</br>";
        foreach($respuestas as $respuesta)
        {
            $letraCorrecta = $respuesta->getEsCorrecta();
                if($letraCorrecta)
                {
                    ?><a type = "text" name = "correcto" style="color: green;"><?php echo $arrayLetras[$j] . " . " . $respuesta->getDescripcion(); ?></a><?php
                    echo "</br>";
                    $j++;
                }
                else if($respuesta->getId() == $infoRespuesta['idRespuesta']) {
                    echo $infoRespuesta['idRespuesta'];
                    echo $respuesta->getId();
                    ?><a type = "text" name = "correcto" style="color: red;"><?php echo $arrayLetras[$j] . " . " . $respuesta->getDescripcion(); ?></a><?php
                    echo "</br>";
                    $j++;
                }
                else
                {
                    ?><a type = "text" name = "correcto" style="color: black;"><?php echo $arrayLetras[$j] . " . " . $respuesta->getDescripcion(); ?></a><?php
                    echo "</br>";
                    $j++;
                }
        }
        echo "</br>";
    }

   echo "</br>";
   echo "</br>";

   ?>
           <a href="screen_student.php" class="button is-link is-light">Atrás</a> 
    </div>
    <?php
    $_SESSION['respuestasIncorrectas'] = NULL;

}

Base("Nota", 'Nota');
?>