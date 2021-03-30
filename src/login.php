<?php
  session_start();

  include("api/Api.class.php");

  $env = parse_ini_file("../.env");

  $api = new Api($env['DB_HOST'], $env['DB_NAME'], $env['DB_USER'], $env['DB_PASSWORD']);
  
  $identificador = "";
  $contraseña = "" ;
  $userid= "1";
  $errorMensaje="";
  $nextPage = false;
  $_SESSION['api'] = serialize($api);
 

  function setSession($user) {
    $_SESSION['email'] = $user->getEmail();
    $_SESSION['password'] = $user->getPassword();
    $_SESSION['user'] = serialize($user);
  }

  function setUserCookie($user) {
    $vencimiento = time() + (30 * 24 * 3600);
      setcookie('email', $user->getEmail(), $vencimiento);
      setcookie('password', $user->getPassword(), $vencimiento);
  }

  function validateLogin($email, $pass) {
    $isValid = false;

    if(strlen($email)!=0 && strlen($pass) !=0) {
      $isValid = true;
    }
    return $isValid;
  }

  if(isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $nextPage = true;
  } 
  else if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $user = $api->getUser($_COOKIE['email'], $_COOKIE['password']);
    setSession($user);
    $nextPage = true;
  }
  else if(isset($_POST['login'])) {
    $userMail = $_POST['email'];
    $userPass = $_POST['password'];
    $loginIsValid = validateLogin($userMail, $userPass);
    $user = $api->getUser($userMail, $userPass);

    if($loginIsValid && $user ) {
      echo "logeao correctamente";
      if(isset($_POST['recordar'])) {
        setUserCookie($user);
      }
      setSession($user);
      $nextPage = true;
    }
    else {
      $errorMensaje = "No ha podido Logearse correctamente";
    }
  }

  if($nextPage) {
    header("location:screen_subjects.php");
    exit;
  }
  else {
  ?>
    <!DOCTYPE html>
    <html>
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
        <script src="https://kit.fontawesome.com/ffaee44ffc.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="styles/login.css" media="screen"/>
      </head>
      <body>
      <section class="hero is-fullheigth">
      <div class="hero-body">
        <div class="container has-text-centered">
          <div class="column is-4 is-offset-4">
            <div class="box">
                
              <h1 class="title">Login</h1>
    
              <form action="login.php" method="POST">
    
                <div class="field">
                  <p class="control has-icons-left">
                    <input class="input" type="email" placeholder="Email" name="email">
                    <span class="icon is-small is-left">
                      <i class="fas fa-envelope"></i>
                    </span>
                  </p>
                </div>
    
                <div class="field">
                  <p class="control has-icons-left">
                    <input class="input" type="password" placeholder="Contraseña" name="password">
                    <span class="icon is-small is-left">
                      <i class="fas fa-lock"></i>
                    </span>
                  </p>
                </div>
                <div class="field">
                  <label class="checkbox">
                    <input type="checkbox" name="recordar">
                    Recordar
                  </label>
                </div>
    
                <div class="field">
                  <input name="login" class="button if-block is-info" value="login" type="submit">
                  <p><?php echo $errorMensaje; ?>
                </div>
                
              </form>
            </div>
          </div>
        </div>
      </div>
      </section>
      </body>
    </html>
<?php
  }
?>

