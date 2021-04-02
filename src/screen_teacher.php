<?php
  session_start();

  include("base.php");

  function ExamenesActivos()
  {
  
    $user = unserialize($_SESSION['user']);

    $idSubject = $_POST['subject'];

    $env = parse_ini_file("../.env");

    $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);

    $exams = $api->getPendingTests($user->getId(), $idSubject);

    foreach($exams as $exam)
    {
    ?>
      <form action="screen_informe.php" method="POST">
        <div class="field">
          <input type = "hidden" name = "exam" value = "<?php echo $exam->getId(); ?>">
          <button class = "button if-block is-info"><?php echo $exam->getTitulo(); ?></button>
        </div>
      </form>
    <?php 
      echo "<br>";
    }

    echo "<br>";
    echo "<br>";
    echo "<br>";

    $exams = $api->getActiveTests($user->getId(), $idSubject);

    foreach($exams as $exam)
    {
    ?>
      <form action="screen_informe.php" method="POST">
        <div class="field">
          <input type = "hidden" name = "exam" value = "<?php echo $exam->getId(); ?>">
          <button class = "button if-block is-info"><?php echo $exam->getTitulo(); ?></button>
        </div>
      </form>
    <?php 
      echo "<br>";
    }

    echo "<br>";
    echo "<br>";
    echo "<br>";

    $exams = $api->getNOTActiveTests($user->getId(), $idSubject);
    foreach($exams as $exam)
  {
  ?>
    <form action="screen_informe.php" method="POST">
      <div class="field">
        <input type = "hidden" name = "exam" value = "<?php echo $exam->getId(); ?>">
        <button class = "button if-block is-info"><?php echo $exam->getTitulo(); ?></button>
      </div>
    </form>
  <?php 
    echo "<br>";
  }

  ?>
    <form action="screen_exam.php" method="POST">
      <div class="field">
        <input type = "hidden" name = "idSubject" value = "<?php echo $idSubject; ?>">
        <button class = "button if-block is-info">Crear Examen</button>
      </div>
    </form>
  <?php 
    echo "<br>";

    ?>
    <form action="screen_question.php" method="POST">
      <div class="field">
        <input type = "hidden" name = "idSubject" value = "<?php echo $idSubject; ?>">
        <button class = "button if-block is-info">Crear Pregunta</button>
      </div>
    </form>
  <?php 
    echo "<br>";

}

Base("Profesor", 'ExamenesActivos');

?>