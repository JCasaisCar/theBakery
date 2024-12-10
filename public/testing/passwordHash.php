<?php
    // Para sacar el "hash" las contraseñas por defecto en la BBDD 
    $hashedAdmin = password_hash("admin", PASSWORD_DEFAULT);
    echo("Hashed admin: " . $hashedAdmin . "<br>");

    $hashedUsuario = password_hash("usuario", PASSWORD_DEFAULT);
    echo("Hashed usuario: " . $hashedUsuario . "<br>");
?>