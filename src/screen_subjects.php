<?php
session_start();

include("base.php");

$env = parse_ini_file("../.env");

function Asignaturas() 
{

  $user = unserialize($_SESSION['user']);

  $subjects = $user->getAsignaturas();

  if($user->getRol() == 'profesor')
  {
    foreach($subjects as $subject)
    {
  ?>
      <form action="screen_teacher.php" method="POST">
        <div class="field">
          <input type = "hidden" name = "subject" value = "<?php echo $subject->getId(); ?>">
          <button class = "button if-block is-info"><?php echo $subject->getName(); ?></button>
        </div>
      </form>
  <?php 
        echo "<br>";
    }
  }else
  {
    foreach($subjects as $subject)
    {
      ?>
      <form action="screen_student.php" method="POST">
        <div class="field">
          <input type = "hidden" name = "subject" value = "<?php echo $subject->getId()?>">
          <button class = "button if-block is-info"><?php echo $subject->getName(); ?></button>
        </div>
      </form>
      <?php 
        echo "<br>";
    }
  }
}

Base("Asignaturas", 'Asignaturas');
?>