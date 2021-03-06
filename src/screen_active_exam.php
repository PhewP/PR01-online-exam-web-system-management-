    <?php

    session_start();
    include("api/Api.class.php");

    function ExamenActual()
    {
        
        $env = parse_ini_file("../.env");
        $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);

        $user = unserialize($_SESSION['user']);
        $preguntasIncorrectas = 0;

        if(isset($_POST['exam']))
        {$_SESSION['idExamen'] = $_POST['exam'];}

        
        $questions = $api->getPreguntas($_SESSION['idExamen']); 

        $arrayQuestions = array_values($questions);
        $_SESSION['nota'] = 0; 
            
        if(isset($_POST['finalizar']))
        {

            if(isset($_POST['correcto']))
            {
                $idRespuesta = explode(",", $_POST['correcto']);
                if($idRespuesta[0] == 'true')
                {
                    $_SESSION['nota']++;
                    $api->setRespuestasUsuario($user->getId(), $idRespuesta[1], $_SESSION['idExamen'], $arrayQuestions[count($arrayQuestions)-1]->getId());
                }else{
                    if($idRespuesta[0] == 'false')
                    {
                        $preguntasIncorrectas++;
                        $api->setRespuestasUsuario($user->getId(), $idRespuesta[1], $_SESSION['idExamen'], $arrayQuestions[count($arrayQuestions)-1]->getId());
                    }
                }
            }

            $idRespuesta = explode(",", $_POST['correcto']);
            echo count($arrayQuestions);            
            $preguntas = $api->getPreguntas($_SESSION['idExamen']);

            $arrayPreguntas = array_values($preguntas);

            $ponderacion = 0.5 * count($arrayPreguntas) / 10;

            $cantidadNotaNegativa = $ponderacion * $preguntasIncorrectas;

            echo $nota = round((10  * $_SESSION['nota'] / count($arrayPreguntas) ) - $cantidadNotaNegativa, 2);

            if($nota < 0)
            { $nota = 0; }

            $api->setNota($nota, $user->getId(), $_SESSION['idExamen']);

            header("location:screen_nota_inmediata.php");
        }else{
            if(isset($_POST['siguiente']))
            {
                $numElementos = 1;

                $idExamen = $_SESSION['idExamen'];
            
                // Recogemos el parametro pag, en caso de que no exista, lo seteamos a 1
                if (isset($_GET['pag'])) {
                    $pagina = $_GET['pag'];
                } else {
                    $pagina = 1;
                    $_GET['pag'] = 0;
                    header("location:screen_active_exam.php?pag=1");
                }

                $arrayLetras = [0=>'A', 1=>'B', 2=>'C', 3=>'D'];

                $j = 0;

                $_SESSION['numPreguntaActual'] = 0; 

                if(isset($_SESSION['numPreguntaActual']) && count($arrayQuestions) > $_SESSION['numPreguntaActual'])
                {
                    $_SESSION['numPreguntaActual'] = --$pagina;
                }else
                { 
                    $_SESSION['numPreguntaActual'] = 0; 
                }

                for($i = $_SESSION['numPreguntaActual']; $i < $_SESSION['numPreguntaActual'] + $numElementos; $i++)
                {
                    echo "<h3 class='title'> Pregunta " . ($i+1) . " : ".$arrayQuestions[$i]->getEnunciado()."</h3>";
                    ?>    
                        <form action="screen_active_exam.php?pag=<?php echo $_GET['pag'] + 1; ?>" method="POST">
                            <div class="field">
                                <div class="control">
                                    <p>
                                        <?php
                                        $arrayQuestions[$i]->getId();
                                        $arrayRespuestas = $api->getRespuestas($arrayQuestions[$i]->getId());
                                        /* ?><input type = "radio" name = "correcto" value = "neutro" checked>Respuesta en blanco<?php
                                        echo "</br>"; */
                                        foreach($arrayRespuestas as $respuesta)
                                        {
                                            $letraCorrecta = $respuesta->getEsCorrecta();
                                            if($letraCorrecta)
                                            {
                                                if($j == 0)
                                                {
                                                    ?>
                                                <input type = "radio" name = "correcto" value = "<?php echo "true,".$respuesta->getId(); ?>" checked><?php echo $arrayLetras[$j] . " . " . $respuesta->getDescripcion();
                                                echo "</br>";
                                                $j++;
                                                }else{
                                                ?>
                                                <input type = "radio" name = "correcto" value = "<?php echo "true,".$respuesta->getId(); ?>"><?php echo $arrayLetras[$j] . " . " . $respuesta->getDescripcion();
                                                echo "</br>";
                                                $j++;}
                                                
                                            }
                                            else
                                            {
                                                if($j == 0)
                                                {
                                                ?>
                                                <input type = "radio" name = "correcto" value = "<?php echo "false,".$respuesta->getId(); ?>" checked><?php echo $arrayLetras[$j] . " . " . $respuesta->getDescripcion();
                                                echo "</br>";
                                                $j++;
                                                }else{
                                                ?>
                                                <input type = "radio" name = "correcto" value = "<?php echo "false,".$respuesta->getId(); ?>"><?php echo $arrayLetras[$j] . " . " . $respuesta->getDescripcion();
                                                echo "</br>";
                                                $j++;}
                                            }
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                    <?php
                }

                
                if(isset($_POST['correcto']))
                {
                    $idRespuesta = explode(",", $_POST['correcto']);
                    if($idRespuesta[0] == 'true')
                    {
                        $_SESSION['nota']++;
                        $api->setRespuestasUsuario($user->getId(), $idRespuesta[1], $idExamen, $arrayQuestions[$i-1]->getId());
                    }else{
                        if($idRespuesta[0] == 'false')
                        {
                            $preguntasIncorrectas++;
                            $api->setRespuestasUsuario($user->getId(), $idRespuesta[1], $idExamen, $arrayQuestions[$i-1]->getId());
                        }
                    }

                }else $_SESSION['nota'];

                ?>
            
                <div>
                    <?php
                    // Si existe el parametro pag
                    
                    // Si existe la paginacion 
                    if (isset($_GET['pag'])) {
                        // Si el numero de registros actual es superior al maximo
                        // Si pongo esto a menos uno no peta pero no sale la ??ltima
                        if ((($pagina) * $numElementos + 1) < count($arrayQuestions)) {
                            date_default_timezone_set('Europe/Madrid');
                            $now = date("Y-m-d H:i:s");
                            if($now >= $api->getHoraFin($idExamen))
                            {
                                ?>
                                    <input type="submit" class="button is-link" name="finalizar" value = "siguiente">
                                <?php
                            }else{
                                ?>
                                    <input type="submit" class="button is-link" name="siguiente" value = "siguiente">

                                <?php
                            }
                            // Sino deshabilito el bot??n
                        } else {
                    ?>
                        <input type="submit" class="button is-link" name="finalizar" value = "finalizar">
                    <?php
                            }
                        // Sino deshabilito el bot??n
                    }

                    ?>
                </div>
                <?php
            }else{
                if(isset($_POST['exam']))
                    { 
                        $_SESSION['idExamen'] = $_POST['exam'];
                    }
                $idExamen = $_SESSION['idExamen'];
                $descripcion = $api->getDescription($idExamen);

                $infoExamen = $api->getExamInformation($idExamen);
                ?>
                    <h1 class="title">Instrucciones:</h1>
                <?php

                $questions = $api->getPreguntas($idExamen); 

                $arrayQuestions = array_values($questions);
                
                echo $descripcion;
                ?>
                <h1 class="title">Titulo: </h1>
                <?php
                echo "<h3>".$infoExamen['nombre']."<h3> </br>";
                echo "<h3 class='title'> Numero de preguntas: <h3>";
                echo " ".$infoExamen['numeroPreguntas']."</br>";
                echo "<h3 class='title'>Tiempo de inicio: <h3>";
                echo " ".$api->getHoraComienzo($idExamen)."</br>";
                echo "<h3 class='title'> Tiempo de Finalizaci??n: <h3>";
                echo " ".$api->getHoraFin($idExamen)."</br>";
                echo "</br>";
                echo "</br>";
                date_default_timezone_set('Europe/Madrid');
                $now = date("Y-m-d H:i:s");


                if($now > $api->getHoraComienzo($idExamen))
                {
                ?>
                    <form action="screen_active_exam.php?pag=1" method="POST">
                        <input type="submit" class="button is-link" name="siguiente" value = "Comenzar intento">
                    </form>
                <?php
                }
                else
                {
                    ?>
                    <form action="screen_active_exam.php?pag=1" method="POST">
                        <input type="submit" class="button is-info is-light " name="disable" value = "Comenzar intento">
                    </form>
                    
                    <div class="field is-grouped">
                    <a href="screen_student.php" class="button is-link is-light">Atr??s</a> 
                    </div>
                <?php
                }

                

            }
        }
    
    }

Base("", 'ExamenActual');
function Base($title, $content) {

?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?php echo $title ?></title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
            <script src="https://kit.fontawesome.com/ffaee44ffc.js" crossorigin="anonymous"></script>
        </head>
        <body>
        <div class="container has-text-centered">
            <div class="column is-8 is-offset-2">
                <div class="box">
                <h1 class="title"><?php echo $title ?></h1>    
                <?php $content()?>
                </div>  
            </div>
        </div>
        </body>
    </html>
<?php
}
?>