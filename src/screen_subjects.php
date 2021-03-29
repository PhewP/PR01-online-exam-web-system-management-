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
          $connection = mysqli_connect("localhost", "root", "", "uca101")
          or die ("Cannot connect to server");

          $instruction = "select nombre 
          from asignatura 
          where id in
          (select id_Asignatura
          from usuarioasignatura
          where id_Usuario =
          (select id
          from usuario))";
          $query = mysqli_query($connection, $instruction)
          or die ("Query failure");

          $instruction2 = "select rol from usuario";
          $query2 = mysqli_query($connection, $instruction2)
          or die ("Query failure");         
          $rol = mysqli_fetch_row($query2);

          if($rol[0] == "profesor" )
          {
            while($subject = mysqli_fetch_assoc($query))
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
            while($subject = mysqli_fetch_assoc($query))
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
          }
          mysqli_close ($connection);
        ?>
      
      </div>
    </div>
  </div>
  </section>
  </body>
</html>