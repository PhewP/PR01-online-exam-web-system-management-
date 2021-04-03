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

    $exams = $api->getPendingTests($user->getId(), $idSubject);

    foreach($exams as $exam)
    {
    ?>
      <form action="screen_modify_exam.php" method="POST">
        <div class="field">
          <input type = "hidden" name = "exam" value = "<?php echo $exam->getId(); ?>">
          <button class = "button is-link is-light"><?php echo $exam->getTitulo(); ?></button>
        </div>
      </form>
    <?php 
      echo "<br>";
    }

    
    $exams = $api->getActiveTests($user->getId(), $idSubject);
    if($exams){
      echo "<hr>";
      ?>
        <h1 class="title">Examenes Pasados</h1> 
      <?php
    }
    foreach($exams as $exam)
    {
    ?>
      <form>
        <div class="field">
          <button class = "button is-link is-light"><?php echo $exam->getTitulo(); ?></button>
        </div>
      </form>
    <?php 
      echo "<br>";
    }

    echo "<hr>";

    $exams = $api->getNOTActiveTests($user->getId(), $idSubject);

    if($exams){
      ?>
        <h1 class="title">Examenes activos</h1> 
      <?php
    }
    foreach($exams as $exam)
  {
  ?>

    <form action="screen_inform.php" method="POST">
      <div class="field">
        <input type = "hidden" name = "exam" value = "<?php echo $exam->getId(); ?>">
        <button class = "button is-link is-light"><?php echo $exam->getTitulo(); ?></button>
      </div>
    </form>
  <?php 
    echo "<br>";
  }
    echo "<hr>"; 
    ?>
      <div class="field is-grouped is-grouped-centered">
        <form action="screen_question.php" method="POST">
          <div class="control">
            <input type = "hidden" name = "idSubject" value = "<?php echo $idSubject; ?>">
            <input type="submit" style="margin: 10px" class="button is-link" value="Crear Pregunta">
          </div>
        </form>
        
        <form action="screen_exam.php" method="POST">
          <div class="control">
          <input type = "hidden" name = "idSubject" value = "<?php echo $idSubject; ?>">
              <input type="submit" style="margin: 10px" class="button is-link" value="Crear Examen">
          </div>
        </form>
      </div>
  <?php 
    echo "<br>";

}

Base("Profesor", 'ExamenesActivos');

?>