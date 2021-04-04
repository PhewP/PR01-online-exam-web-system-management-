<?php
include('base.php');

function frec_notas($sup, $inf, $notas) {
    foreach($notas as $nota){
        if($nota >=$inf && $nota <=$sup){
            $frecNotas[] = $nota;
        }
    }
    return $frecNotas;
}

function report(){

    // get todos los examenes de un tema de una asignatura

    $idExamen = $_POST['idExam'];
    $env = parse_ini_file("../.env");
    $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);

    $notas = $api->getAllMarks($idExamen);
    // no tengo examenes así que me los invento
    // Descomentar luego al probarlo con todo junto
    $notas = array(5.6, 6.4, 6.7, 0.6, 3, 2, 3, 2 ,1 ,6, 8, 8, 7, 9, 10, 9 ,8, 7, 5, 3, 2, 1);

    $numExamenes = count($notas);
    $notaMasAlta = max($notas);
    $notaMasBaja = min($notas);
    $numeroDeSobresalientes = count(frec_notas(10, 9, $notas));
    $numeroDeNotables = count(frec_notas(8, 7, $notas));
    $numberoDeBien = count(frec_notas(6, 6, $notas));
    $numeroDeSuficientes = count(frec_notas(5, 5, $notas));
    $numeroDeInsuficientes = count(frec_notas(4, 0, $notas));
    $numeroDeAprobados = $numeroDeSobresalientes + $numeroDeNotables + $numberoDeBien + $numeroDeSuficientes;
    $ratioAprobados =  round($numeroDeAprobados / $numExamenes,2);

    $notaMedia= round(array_sum($notas) / $numExamenes);
    ?>
    
    <div class="tile is-ancestor">
  <div class="tile is-vertical is-8">
    <div class="tile">
      <div class="tile is-parent is-vertical">
        <article class="tile is-child notification is-primary">
          <p class="title">Nota más alta:</p>
          <p class="subtitle"><?php echo $notaMasAlta?></p>
        </article>
        <article class="tile is-child notification is-danger">
          <p class="title">Nota más baja:</p>
          <p class="subtitle"><?php echo $notaMasBaja?></p>
        </article>
      </div>
      <div class="tile is-parent">
        <article class="tile is-child notification is-info">
        <div class="content">
        <p class="title">Información por nota</p>
        <p class="subtitle">Número de Sobresalientes: <?php echo " ".$numeroDeSobresalientes ?></p>
        <p class="subtitle">Número de Notables: <?php echo " ".$numeroDeNotables ?></p>
        <p class="subtitle">Número de Bien: <?php echo " ".$numberoDeBien ?></p>
        <p class="subtitle">Número de Suficientes: <?php echo " ".$numeroDeSuficientes?></p>
        <p class="subtitle">Número de Insuficientes: <?php echo " ".$numeroDeInsuficientes ?></p>
        <div class="content">
          <!-- Content -->
        </div>
      </div>
        </article>
      </div>
    </div>
  </div>
  <div class="tile is-parent">
    <article class="tile is-child notification is-success">
      <div class="content">
        <p class="title">Información General</p>
        <div class="content">
        <p class= subtitle>Número de Aprobados:<?php echo " ".$numeroDeAprobados ?></p>
        <p class= subtitle>Número de Suspensos:<?php echo " ".$numeroDeInsuficientes ?></p>
        <p class= subtitle>Número de Ratio aprobados:<?php echo " ".$ratioAprobados ?></p>
        <p class= subtitle>Nota media:<?php echo " ".$notaMedia?></p>
        </div>
      </div>
    </article>
  </div>
</div>
<div class="field is-grouped">
                <div class="control">    
                </div>
                <a href="screen_teacher.php" class="button is-link is-light">Atrás</a> 
        </div>
<?php
}
Base("Report", "report");
?>