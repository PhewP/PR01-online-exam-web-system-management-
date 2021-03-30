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

  $subject = unserialize(($_SESSION['subject']));
  ?>      
      </div>
    </div>
  </div>
  </section>
  </body>
</html>