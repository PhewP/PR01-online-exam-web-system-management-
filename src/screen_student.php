<?php
  session_start();

  include("base.php");

  function ExamenesActivos()
  {
  
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

    $exams = $api->getPendingTestsStudent($idSubject);

    if($exams){
      echo "<hr>";
      ?>
        <h1 class="title">Examenes Activos</h1> 
      <?php
    }

    foreach($exams as $exam)
    {
    ?>
      <form action="screen_active_exam.php" method="POST">
        <div class="field">
          <?php
          if($api->getMark($user->getId(), $exam->getId()))
          {
          ?>
            <button disabled class = "button is-link is-light"><?php echo $exam->getTitulo(); ?></button>
            <?php
          }else{
          ?>
            <input type = "hidden" name = "exam" value = "<?php echo $exam->getId(); ?>">
            <button class = "button is-link is-light"><?php echo $exam->getTitulo(); ?></button>
          <?php
          }
          ?>
        </div>
      </form>
    <?php 
      echo "<br>";
    }

    echo "<hr>";

    $exams = $api->getNOTActiveTestsStudent($idSubject);

    if($exams){
      echo "<hr>";
      ?>
        <h1 class="title">Examenes Finalizados</h1> 
      <?php
    }
    
    foreach($exams as $exam)
    {
    ?>
      <form action="screen_nota.php" method="POST">
        <div class="field">
          <input type = "hidden" name = "exam" value = "<?php echo $exam->getId(); ?>">
          <button class = "button is-link is-light"><?php echo $exam->getTitulo(); ?></button>
        </div>
      </form>
    <?php 
      echo "<br>";
    }
    echo "<hr>"; 
}

Base("Estudiante", 'ExamenesActivos');
    ?>