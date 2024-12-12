<?php
// Configuramos el namespace
namespace theBakery\public;

use theBakery\public\src\ConexionDB;

// Incluimos la conexión a la base de datos
require_once("src/ConexionDB.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash de la contraseña

    // Conexión a la base de datos
    $conexionDB = ConexionDB::obtenerInstancia();
    $conexion = $conexionDB->obtenerConexion();

    // Insertar cliente
    $query = $conexion->prepare("INSERT INTO usuarios (name, username, email, password, rol) VALUES (?, ?, ?, ?, 'cliente')");
    if ($query->execute([$name, $username, $email, $password])) {
        header('Location: mainAdmin.php'); // Redirigir al listado
        exit;
    } else {
        echo "<p class='text-danger text-center'>Error al crear el cliente</p>";
    }
}
?>
