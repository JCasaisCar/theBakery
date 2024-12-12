<?php
// Configuramos el namespace
namespace theBakery\public\src;

use PDO;

require_once("ConexionDB.php");

// Conexión a la base de datos
$conexionDB = ConexionDB::obtenerInstancia();
$conexion = $conexionDB->obtenerConexion();

// Obtener los datos del cliente por ID
$id = $_POST['id'];
$query = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
$query->execute([$id]);
$cliente = $query->fetch(PDO::FETCH_ASSOC);


// Configuración básica del formulario para dar de alta un nuevo cliente
$title = "Actualizar Cliente";
require_once("../index1.php");
?>

    <div class="container my-5">
        <h1 class="text-center">Actualizar Cliente</h1>
        <!-- Usamos "onsubmit" para que cuando le demos al boton de "submit" antes de enviar los datos los valide con la función que hemos definido en js -->
        <form action="updateCliente.php" method="POST" onsubmit="return validarFormulario(this)">
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
                <label for="mail" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="mail" name="mail" value="<?= $cliente['email'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
        </form>
    </div>
    
<?php require_once("../index2.php"); ?>
