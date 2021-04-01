<?php

function getDatetimeNow() {
    $tz_object = new DateTimeZone('Europe/Madrid');

    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y-m-d');
}

function Base($title, $content) {
    include("components/navbar.php");
    include("api/Api.class.php");

    print('
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>'.$title.'</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
        <script src="https://kit.fontawesome.com/ffaee44ffc.js" crossorigin="anonymous"></script>
    </head>
    <body>
    '.Navbar().'
    <div class="container has-text-centered">
        <div class="column is-8 is-offset-2">
            <div class="box">
            <h1 class="title">'.$title.'</h1>'     
            .$content().'
            </div>
        </div>
    </div>
    </body>
    </html>
    ');
}
?>