<?php
// Configuramos el namespace
namespace theBakery\public;

// Usamos la ruta del namespace
use theBakery\public\src\Dulce;

require_once("src/Dulce.php");

// Recogemos los datos del formulario
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];

// Insertamos el nuevo dulce en la base de datos
$nombreDulce = str_replace(" ", "", $nombre);
$dulce = new Dulce($nombreDulce, $precio, $descripcion, $categoria);
$dulce->createDulce();

// Redirigimos a la lista de dulces
header('Location: mainAdmin.php');
exit;
?>