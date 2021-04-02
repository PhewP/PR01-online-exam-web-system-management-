<?php

function ResetSession($user) {
    $_SESSION['email'] = $user->getEmail();
    $_SESSION['password'] = $user->getPassword();
    $_SESSION['user'] = serialize($user);
}

function ResetUserCookie($user) {
      setcookie('email', NULL, -1);
      setcookie('password', NULL, -1);
}

function cleanSession() {
    echo"limpiaaa";
    session_start();
    $user=unserialize($_SESSION['user']);
    session_destroy();
    ResetUserCookie($user);
    header("Location: login.php");
}


function Navbar() {
    $uri=$_SERVER['REQUEST_URI'];
    echo $uri;
    $uri = explode("/", $uri);
    $uri = end($uri);

    if(isset($_POST['logout']))
        cleanSession();
    else {
    ?>
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="https://esingenieria.uca.es/">
            <img src="https://exterior.fe.ccoo.es/a544ca1d3464b59edde9527d0ea5b6ac000063.png" width="50" height="500">
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a href="screen_subjects.php" class="navbar-item">
                    Asignaturas
                </a>
            </div>  
            
            <div class="navbar-end">
                <div class="navbar-item">
                    <form action=<?php echo $uri?> method="POST">
                        <input name="logout" class="button is-primary" value='Log out' type="submit">
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <?php
    }
}
?>