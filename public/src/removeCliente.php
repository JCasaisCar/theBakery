<?php
    // Configuramos el namespace
    namespace theBakery\public\src;

    // Incluimos el archivo de conexión
    require_once("ConexionDB.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validamos el parámetro "id"
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            die('Error: ID inválido o no proporcionado');
        }

        $id = (int) $_POST['id']; // Aseguramos que es un número entero

        // Conexión a la base de datos
        $conexionDB = ConexionDB::obtenerInstancia();
        $conexion = $conexionDB->obtenerConexion();

        // Verificamos si el cliente existe antes de eliminar
        $queryCheck = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
        $queryCheck->execute([$id]);
        $usuario = $queryCheck->fetch();

        if (!$usuario) {
            die('Error: El cliente no existe');
        }

        // Eliminamos un cliente
        $query = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
        $query->execute([$id]);

        header('Location: ../mainAdmin.php'); // Redirigimos a "mainAdmin.php"
        exit;
    }
?>
