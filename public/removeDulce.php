<?php
// Configuramos el namespace
namespace theBakery\public;

// Usamos la ruta del namespace
use theBakery\public\src\Dulce;

require_once("src/Dulce.php");

// Recogemos el ID del dulce a eliminar
$id = $_POST['id'];

// Eliminamos el dulce de la base de datos
$dulce = new Dulce("", 0, "", "");
$dulce->deleteDulce($id);

// Redirigimos a la lista de dulces
header('Location: mainAdmin.php');
exit;
?>
