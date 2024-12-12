<?php
namespace theBakery\public;

use theBakery\public\src\ConexionDB;

require_once("src/ConexionDB.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar el parámetro 'id'
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        die('Error: ID inválido o no proporcionado');
    }

    $id = (int) $_POST['id']; // Asegurar que es un número entero

    // Conexión a la base de datos
    $conexionDB = ConexionDB::obtenerInstancia();
    $conexion = $conexionDB->obtenerConexion();

    // Verificar si el cliente existe antes de eliminar
    $queryCheck = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
    $queryCheck->execute([$id]);
    $usuario = $queryCheck->fetch();

    if (!$usuario) {
        die('Error: El cliente no existe');
    }

    // Eliminar cliente
    $query = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $query->execute([$id]);

    header('Location: mainAdmin.php'); // Redirigir al listado
    exit;
}
?>
