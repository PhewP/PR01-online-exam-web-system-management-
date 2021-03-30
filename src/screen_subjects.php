<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Show subjects</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <script src="https://kit.fontawesome.com/ffaee44ffc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/login.css" media="screen"/>
  </head>
  <body>
  <section class="hero is-fullheigth">
  <div class="hero-body">
    <div class="container has-text-centered">
      <div class="column is-4 is-offset-4">

<?php
  session_start();

  include("api/Api.class.php");

  $env = parse_ini_file("../.env");

  $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);

  $user = unserialize($_SESSION['user']);

  $subjects = $user->getAsignaturas();

  if($user->getRol() == 'profesor')
  {
    foreach($subjects as $subject)
    {
      ?>
        <div class="field">
          <input class="button if-block is-info" type="button" 
          onclick = "window.location.href = 'screen_teacher.php'" 
          value = <?php print $subject->getName(); ?> type = "submit">
        </div>
      <?php 
        echo "<br>";
    }
  }else
  {
    foreach($subjects as $subject)
    {
      ?>
        <div class="field">
          <input class="button if-block is-info" type="button" 
          onclick = "window.location.href = 'screen_student.php'"
          value = <?php print $subject->getName(); ?> type = "submit">
        </div>
      <?php 
        echo "<br>";
    }
  }
    /* if($user->getRol() == "profesor" )
  {
    while($subject = mysqli_fetch_assoc($consulta))
    {
      ?>
        <div class="field">
          <input class="button if-block is-info" type="button" 
          onclick = "window.location.href = 'screen_teacher.php'" 
          value = <?php print $subject['nombre']; ?>>
        </div>
      <?php 
      echo "<br>";
    }
  }else
  {
    while($subject = mysqli_fetch_assoc($consulta))
    {
      ?>
          <div class="field">
            <input class="button if-block is-info" type="button" 
            onclick = "window.location.href = 'screen_student.php'" 
            value = <?php print $subject['nombre']; ?>>
          </div>
      <?php 
      echo "<br>";
    }
  } */
  ?>      
      </div>
    </div>
  </div>
  </section>
  </body>
</html>