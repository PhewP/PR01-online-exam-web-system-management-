     <?php

    session_start();
    include("api/Api.class.php");

    function ExamenActual()
    {
        $env = parse_ini_file("../.env");
        $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);
        
        if(isset($_POST['finalizar']))
        {
            $user = unserialize($_SESSION['user']);

            $preguntas = $api->getPreguntas($_SESSION['idExamen']);

            $arrayPreguntas = array_values($preguntas);

            $nota = 10  * $_SESSION['nota'] / count($arrayPreguntas);

            $api->setNota($nota, $user->getId(), $_SESSION['idExamen']);

            header("location:screen_subjects.php");
        }else{

        $numElementos = 1;

        

        if(isset($_POST['exam']))
        { 
            $_SESSION['idExamen'] = $_POST['exam'];
            $_SESSION['nota'] = 0; 
        }

        $idExamen = $_SESSION['idExamen'];
    
        // Recogemos el parametro pag, en caso de que no exista, lo seteamos a 1
        if (isset($_GET['pag'])) {
            $pagina = $_GET['pag'];
        } else {
            $pagina = 1;
            $_GET['pag'] = 0;
            header("location:screen_active_exam.php?pag=1");
        }

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
            echo $arrayQuestions[$i]->getEnunciado();
            ?>    
                <form action="screen_active_exam.php?pag=<?php echo $_GET['pag'] + 1; ?>" method="POST">
                    <div class="field">
                        <div class="control">
                            <p>
                                <?php
                                $arrayQuestions[$i]->getId();
                                $arrayRespuestas = $api->getRespuestas($arrayQuestions[$i]->getId());
                                foreach($arrayRespuestas as $respuesta)
                                {
                                    $letraCorrecta = $respuesta->getEsCorrecta();
                                    if($letraCorrecta)
                                    {
                                        ?><input type = "radio" name = "correcto" value = "true"><?php echo $respuesta->getDescripcion();
                                        echo "</br>";
                                    }
                                    else
                                    {
                                        ?><input type = "radio" name = "correcto" value = "false"><?php echo $respuesta->getDescripcion();
                                        echo "</br>";
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
                $_SESSION['nota']++;
        }else $_SESSION['nota'];

        ?>
    
        <div>
            <?php
            // Si existe el parametro pag
            
            // Si existe la paginacion 
            if (isset($_GET['pag'])) {
                // Si el numero de registros actual es superior al maximo
                if ((($pagina) * $numElementos + 1) < count($arrayQuestions)) {
            ?>
                    <input type="submit" class="button is-link" name="siguiente" value = "siguiente">

            <?php
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
        </form>
        <?php
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