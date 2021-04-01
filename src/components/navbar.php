<?php
function Navbar() {
    return '<nav class="navbar" role="navigation" aria-label="main navigation">
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
    <a class="button is-primary">
    <strong>Log out</strong>
    </a>
    </div>
    </div>
    </div>
    </nav>';
}
?>