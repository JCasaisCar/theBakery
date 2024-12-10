<?php
    namespace theBakery\public;

    // Usamos la variable "$title" para asignar el título de la página a "index"
    $title = "index";

    require_once("index1.php");

    if (isset($_COOKIE['username'])) {
        $username = $_COOKIE['username'];
        echo("<h1>¡¡Bienvenid@ $username!!</h1>");
    } else {
        echo("No existe la cookie");
    }

    require_once("index2.php");
?>