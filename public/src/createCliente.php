<?php
    // Configuramos el namespace
    namespace theBakery\public\src;

    // Incluimos la conexión a la base de datos
    require_once("ConexionDB.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $mail = $_POST['mail'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Convertimos a hash la contraseña

        // Conexión a la base de datos
        $conexionDB = ConexionDB::obtenerInstancia();
        $conexion = $conexionDB->obtenerConexion();

        // Insertamos el cliente
        $query = $conexion->prepare("INSERT INTO usuarios (name, username, email, password, rol) VALUES (?, ?, ?, ?, 'cliente')");
        if ($query->execute([$name, $username, $mail, $password])) {
            header('Location: ../mainAdmin.php'); // Redirigir al listado
            exit;
        } else {
            echo "<p class='text-danger text-center'>Error al crear el cliente</p>";
        }
    }
?>
