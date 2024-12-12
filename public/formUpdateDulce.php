<?php 
// Configuramos el namespace
namespace theBakery\public;

// Usamos la ruta del namespace y PDO
use PDO;
use theBakery\public\src\ConexionDB;

require_once("src/ConexionDB.php");

// Establecemos la conexión a la base de datos
$conexionDB = ConexionDB::obtenerInstancia();
$conexion = $conexionDB->obtenerConexion();

// Recogemos el ID del dulce a actualizar
$id = $_POST['id'];

// Consultamos los datos del dulce
$query = $conexion->prepare("SELECT id, nombre, precio, descripcion, categoria FROM dulces WHERE id = ?");
$query->execute([$id]);
$dulce = $query->fetch(PDO::FETCH_ASSOC);

// Si no se encuentra el dulce, redirigimos
if (!$dulce) {
    echo "<p>Dulce no encontrado.</p>";
    exit;
}

$title = "Actualizar Dulce";
require_once("index1.php");

// Mostramos el formulario de actualización
echo ("<h3 class='mb-4'>Actualizar Dulce</h3>");
echo ("<form action='updateDulce.php' method='POST'>
        <input type='hidden' name='id' value='{$dulce['id']}'>
        <div class='mb-3'>
            <label for='nombre' class='form-label'>Nombre</label>
            <input type='text' class='form-control' id='nombre' name='nombre' value='{$dulce['nombre']}' required>
        </div>
        <div class='mb-3'>
            <label for='precio' class='form-label'>Precio</label>
            <input type='number' class='form-control' id='precio' name='precio' value='{$dulce['precio']}' required>
        </div>
        <div class='mb-3'>
            <label for='descripcion' class='form-label'>Descripción</label>
            <input type='text' class='form-control' id='descripcion' name='descripcion' value='{$dulce['descripcion']}' required>
        </div>
        <div class='mb-3'>
            <label for='categoria' class='form-label'>Categoría</label>
            <select class='form-select' id='categoria' name='categoria' required>
                <option value='Bollos' " . ($dulce['categoria'] == 'Bollos' ? 'selected' : '') . ">Bollos</option>
                <option value='Chocolates' " . ($dulce['categoria'] == 'Chocolates' ? 'selected' : '') . ">Chocolates</option>
                <option value='Tartas' " . ($dulce['categoria'] == 'Tartas' ? 'selected' : '') . ">Tartas</option>
            </select>
        </div>
        <button type='submit' class='btn btn-primary'>Actualizar Dulce</button>
    </form>");

// Incluimos el archivo para el pie de página
require_once("index2.php");
?>
