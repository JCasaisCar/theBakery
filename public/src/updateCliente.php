<?php
// Configuramos el namespace
    namespace theBakery\public\src;

    // Incluimos el archivo de dulce
    require_once("ConexionDB.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $mail = $_POST['mail'];
        // Usamos "?" para hacer como un "if"
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

        // Conexión a la base de datos
        $conexionDB = ConexionDB::obtenerInstancia();
        $conexion = $conexionDB->obtenerConexion();

        // Actualizamos cliente
        if ($password) {
            $query = $conexion->prepare("UPDATE usuarios SET name = ?, username = ?, email = ?, password = ? WHERE id = ?");
            $query->execute([$name, $username, $mail, $password, $id]);
        } else {
            $query = $conexion->prepare("UPDATE usuarios SET name = ?, username = ?, email = ? WHERE id = ?");
            $query->execute([$name, $username, $mail, $id]);
        }

        header('Location: ../mainAdmin.php'); // Redirigimos a "mainAdmin.php"
        exit;
    }
?>
