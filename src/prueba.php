<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ejemplo de paginacion</title>
</head>
 
<body>
 
    <?php

    session_start();
 
    $env = parse_ini_file("../.env");
    include("api/Api.class.php");

    $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);
 
    $numElementos = 1;

    $user = unserialize($_SESSION['user']);

    $subjects = $user->getAsignaturas();
 
    // Recogemos el parametro pag, en caso de que no exista, lo seteamos a 1
    if (isset($_GET['pag'])) {
        $pagina = $_GET['pag'];
    } else {
        $pagina = 1;
    }
 
    ?>
 
 
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
        </tr>
 
        <?php

        $arraySubjects = array_values($subjects);

        $_SESSION['numAsignaturaActual'] = 0; 

        if(isset($_SESSION['numAsignaturaActual']) && count($arraySubjects) > $_SESSION['numAsignaturaActual'])
        {
            echo $_SESSION['numAsignaturaActual'] = --$pagina;
        }else
        { 
            $_SESSION['numAsignaturaActual'] = 0; 
        }
 
        for($i = $_SESSION['numAsignaturaActual']; $i < $_SESSION['numAsignaturaActual'] + $numElementos; $i++)
        {
            echo "<tr>";
            echo "<td>" . $arraySubjects[$i]->getId() . "</td>";
            echo "<td>" . $arraySubjects[$i]->getName() . "</td>";
            echo "</tr>";
        }
 
        ?>
 
    </table>
 
    <div>
        <?php
        // Si existe el parametro pag
        

        if (isset($_GET['pag'])) {
            // Si pag es mayor que 1, ponemos un enlace al anterior
            if ($_GET['pag'] > 1) {
                ?>
                <a href="prueba.php?pag=<?php echo $_GET['pag'] - 1; ?>"><button>Anterior</button></a>
            <?php
                    // Sino deshabilito el botón
                } else {
                    ?>
                <a href="#"><button disabled>Anterior</button></a>
            <?php
                }
                ?>
 
        <?php
        } else {
            // Sino deshabilito el botón
            ?>
            <a href="#"><button disabled>Anterior</button></a>
            <?php
        }
 
             
 
        // Si existe la paginacion 
        if (isset($_GET['pag'])) {
            // Si el numero de registros actual es superior al maximo
            if ((($pagina) * $numElementos + 1) < count($arraySubjects)) {
                ?>
            <a href="prueba.php?pag=<?php echo $_GET['pag'] + 1; ?>"><button>Siguiente</button></a>
        <?php
                // Sino deshabilito el botón
            } else {
                ?>
            <a href="#"><button disabled>Siguiente</button></a>
        <?php
            }
 
            ?>
 
        <?php
            // Sino deshabilito el botón
        } else {
            ?>
            <a href="prueba.php?pag=2"><button>Siguiente</button></a>
        <?php
        }
 
 
        ?>
 
 
    </div>
 
</body>
 
</html>