<?php
    namespace theBakery\public;

    // Usamos la variable "$title" para asignar el título de la página a "mainAdmin"
    $title = "mainAdmin";

    require_once("index1.php");

    if (isset($_COOKIE['username'])) {
        $username = $_COOKIE['username'];
        echo("<h1>¡¡Bienvenid@ $username!!</h1>");
    } else {
        echo("No existe la cookie");
    }

    echo("Generamos los datos para admin");

    echo("<h2><a onclick='cerrarSesion()'>Pincha aqui para cerrar la sesión</a></h2>");

    require_once("index2.php");
?>


<script>
    function cerrarSesion() {
        // Eliminamos las cookies de sesión
        document.cookie = 'username=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
        document.cookie = 'rol=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';

        // Redirigimos al usuario a la página de login
        window.location.href = 'index.php';
    }
</script>