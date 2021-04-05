    <?php

    session_start();
    include("api/Api.class.php");

    function ExamenActual()
    {
        $env = parse_ini_file("../.env");
        $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);

        $user = unserialize($_SESSION['user']);
        $preguntasIncorrectas = 0;
            
        if(isset($_POST['finalizar']))
        {
            $preguntas = $api->getPreguntas($_SESSION['idExamen']);

            $arrayPreguntas = array_values($preguntas);

            $ponderacion = 0.5 * count($arrayPreguntas) / 10;

            $cantidadNotaNegativa = $ponderacion * $preguntasIncorrectas;

            $nota = round((10  * $_SESSION['nota'] / count($arrayPreguntas) ) - $cantidadNotaNegativa, 2);

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

                $questions = $api->getPreguntas($idExamen); 

                $arrayQuestions = array_values($questions);

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
                    echo "<h3 class='title'>".$arrayQuestions[$i]->getEnunciado()."</h3>";
                    ?>    
                        <form action="screen_active_exam.php?pag=<?php echo $_GET['pag'] + 1; ?>" method="POST">
                            <div class="field">
                                <div class="control">
                                    <p>
                                        <?php
                                        $arrayQuestions[$i]->getId();
                                        $arrayRespuestas = $api->getRespuestas($arrayQuestions[$i]->getId());
                                        ?><input type = "radio" name = "correcto" value = "neutro" checked>Respuesta en blanco<?php
                                        echo "</br>";
                                        foreach($arrayRespuestas as $respuesta)
                                        {
                                            $letraCorrecta = $respuesta->getEsCorrecta();
                                            if($letraCorrecta)
                                            {
                                                ?><input type = "radio" name = "correcto" value = "true"><?php echo $arrayLetras[$j] . " . " . $respuesta->getDescripcion();
                                                echo "</br>";
                                                $j++;
                                                $api->setRespuestasUsuario($user->getId(), $respuesta->getId(), $idExamen, $arrayQuestions[$i]->getId());
                                            }
                                            else
                                            {
                                                ?><input type = "radio" name = "correcto" value = "false"><?php echo $arrayLetras[$j] . " . " . $respuesta->getDescripcion();
                                                echo "</br>";
                                                $j++;
                                                $api->setRespuestasUsuario($user->getId(), $respuesta->getId(), $idExamen, $arrayQuestions[$i]->getId());
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
                    if($_POST['correcto'] == 'true')
                    {
                        $_SESSION['nota']++;
                    }else{
                        if($_POST['correcto'] == 'false')
                        {
                            $preguntasIncorrectas++;
                        }else{
                            $api->setRespuestasUsuario($user->getId(), 0, $idExamen, $arrayQuestions[$i]->getId());
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
                            // Sino deshabilito el botón
                        } else {
                    ?>
                        <input type="submit" class="button is-link" name="finalizar" value = "finalizar">
                    <?php
                            }
                        // Sino deshabilito el botón
                    }

                    ?>
                </div>
                <?php
            }else{
                if(isset($_POST['exam']))
                    { 
                        $_SESSION['idExamen'] = $_POST['exam'];
                        $_SESSION['nota'] = 0; 
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
                echo "<h3 class='title'> Tiempo de Finalización: <h3>";
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