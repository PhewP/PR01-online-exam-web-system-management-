<?php
  session_start();

  include("base.php");

  function ExamenesActivos()
  {
  
    $user = unserialize($_SESSION['user']);

    $id = $_POST['subject'];

    $env = parse_ini_file("../.env");

    $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);

    $exams = $api->getPendingTests($user->getId(), $id);

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

    echo "<hr>";

    $exams = $api->getActiveTests($user->getId(), $id);

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

    $exams = $api->getNOTActiveTests($user->getId(), $id);
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

}

Base("Estudiante", 'ExamenesActivos');

?>