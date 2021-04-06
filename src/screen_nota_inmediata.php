<?php
session_start();

include("base.php");

function Nota() 
{
    $user = unserialize($_SESSION['user']);

    $env = parse_ini_file("../.env");

    if(isset($_POST['exam']))
    {
        $_SESSION['idExamen'] = $_POST['exam'];
        $idExam = $_SESSION['idExamen'];
    }else{
        $idExam = $_SESSION['idExamen'];
    }


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
    $arrayQuestions = array_values($preguntas);
    for($i = 0; $i < count($arrayQuestions)-1 ; $i++)
    {
        $respuestas = $api->getRespuestas($arrayQuestions[$i]->getId());
        $arrayAnswers = array_values($respuestas);
        echo "</br>";
        ?><b type = "text" name = "correcto" style="color: black;"><?php echo $api->getTituloPregunta($arrayQuestions[$i]->getId()); ?></b><?php
            echo "</br>";
        for($j = 0; $j < count($arrayAnswers) ; $j++)
        {

            $api->getRespuestaUsuario($user->getId(), $idExam,$arrayQuestions[$i+1]->getId());
            $idrespuestacorrecta = $api->getRespuestaUsuario($user->getId(), $idExam,$arrayQuestions[$i+1]->getId());

            $letraCorrecta = $arrayAnswers[$j]->getEsCorrecta();
            $arrayAnswers[$j]->getId();
             if($letraCorrecta)
            {
                ?><a type = "text" name = "correcto" style="color: green;"><?php echo $arrayLetras[$j] . " . " . $arrayAnswers[$j]->getDescripcion(); ?></a><?php
                echo "</br>";
            }
            else if($arrayAnswers[$j]->getId() == $idrespuestacorrecta) {
                $arrayAnswers[$j]->getId();
                ?><a type = "text" name = "correcto" style="color: red;"><?php echo $arrayLetras[$j] . " . " . $arrayAnswers[$j]->getDescripcion(); ?></a><?php
                echo "</br>";
            }
            else
            {
                ?><a type = "text" name = "correcto" style="color: black;"><?php echo $arrayLetras[$j] . " . " . $arrayAnswers[$j]->getDescripcion(); ?></a><?php
                echo "</br>";
            }
            
        }
    }
    echo "</br>";
    ?><b type = "text" name = "correcto" style="color: black;"><?php echo $api->getTituloPregunta($arrayQuestions[$i]->getId()); ?></b><?php
    echo "</br>";

    $respuestas = $api->getRespuestas($arrayQuestions[$i]->getId());
    $arrayAnswers = array_values($respuestas);

    for($j = 0; $j < count($arrayAnswers) ; $j++)
    {
                $idrespuestacorrecta = $api->ultimo($user->getId(), $idExam,$arrayQuestions[$i]->getId());

                $letraCorrecta = $arrayAnswers[$j]->getEsCorrecta();
                $arrayAnswers[$j]->getId();
                if($letraCorrecta)
                {
                    ?><a type = "text" name = "correcto" style="color: green;"><?php echo $arrayLetras[$j] . " . " . $arrayAnswers[$j]->getDescripcion(); ?></a><?php
                    echo "</br>";
                }
                else if($arrayAnswers[$j]->getId() == $idrespuestacorrecta) {
                    $arrayAnswers[$j]->getId();
                    ?><a type = "text" name = "correcto" style="color: red;"><?php echo $arrayLetras[$j] . " . " . $arrayAnswers[$j]->getDescripcion(); ?></a><?php
                    echo "</br>";
                }
                else
                {
                    ?><a type = "text" name = "correcto" style="color: black;"><?php echo $arrayLetras[$j] . " . " . $arrayAnswers[$j]->getDescripcion(); ?></a><?php
                    echo "</br>";
                }
            }

/*     foreach($preguntas as $pregunta)
    {
        $j = 0;
        $respuestas = $api->getRespuestas($pregunta->getId());
        ?><b type = "text" name = "correcto" style="color: black;"><?php echo $api->getTituloPregunta($pregunta->getId()); ?></b><?php
        echo "</br>";
        foreach($respuestas as $respuesta)
        {
            echo $respuesta->getId();
            echo $api->getRespuestaUsuario($user->getId(), $idExam, $pregunta->getId());
            $letraCorrecta = $respuesta->getEsCorrecta();
                if($letraCorrecta)
                {
                    ?><a type = "text" name = "correcto" style="color: green;"><?php echo $arrayLetras[$j] . " . " . $respuesta->getDescripcion(); ?></a><?php
                    echo "</br>";
                    $j++;
                }
                else if($respuesta->getId() == $api->getRespuestaUsuario($user->getId(), $idExam, $pregunta->getId())) {
                   // echo $infoRespuesta['idRespuesta'];
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
    } */

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