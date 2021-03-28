<?php
    session_start();
    echo "Session: ".$_SESSION['email'];
    echo "Session: ".$_SESSION['password'];

    if(isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
        echo "Cookie: ".$_COOKIE['email'];
        echo "Cookie: ".$_COOKIE['password'];        
    }
?>