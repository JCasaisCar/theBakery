<?php
// Configuramos el namespace
namespace theBakery\public;

use theBakery\public\src\ConexionDB;
use PDO;

require_once("src/ConexionDB.php");

// Conexión a la base de datos
$conexionDB = ConexionDB::obtenerInstancia();
$conexion = $conexionDB->obtenerConexion();

// Obtener los datos del cliente por ID
$id = $_GET['id'];
$query = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
$query->execute([$id]);
$cliente = $query->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Actualizar Cliente</h1>
        <form action="updateCliente.php" method="POST">
            <input type="hidden" name="id" value="<?= $cliente['id'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $cliente['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $cliente['username'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $cliente['email'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
        </form>
    </div>
</body>
</html>
