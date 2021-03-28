<?php
  session_start();

  $mensaje = "";

  if(isset($_SESSION['email'])) {

    $id = $_SESSION['email'];
    $pwd = $_SESSION['password'];
    echo $_POST['recordar'];

    if(isset($_POST['recordar'])) {
      $vencimiento = time() + (30 * 24 * 3600);
      setcookie('email', $id, $vencimiento);
      setcookie('password', $pwd, $vencimiento);

      $mensaje = "Conexion automatica activada";
    } elseif (isset($_POST['recordar'])) {
      setcookie('email');
      setcookie('password');
      $mensaje = 'Conexion automatica desactivada';
    }
  } else {
    header('Location:login.html');
    exit;
    
  }
?>