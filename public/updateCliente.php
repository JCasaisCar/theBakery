<?php
namespace theBakery\public;

use theBakery\public\src\ConexionDB;

require_once("src/ConexionDB.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // Conexión a la base de datos
    $conexionDB = ConexionDB::obtenerInstancia();
    $conexion = $conexionDB->obtenerConexion();

    // Actualizar cliente
    if ($password) {
        $query = $conexion->prepare("UPDATE usuarios SET name = ?, username = ?, email = ?, password = ? WHERE id = ?");
        $query->execute([$name, $username, $email, $password, $id]);
    } else {
        $query = $conexion->prepare("UPDATE usuarios SET name = ?, username = ?, email = ? WHERE id = ?");
        $query->execute([$name, $username, $email, $id]);
    }

    header('Location: mainAdmin.php'); // Redirigir al listado
    exit;
}
?>
