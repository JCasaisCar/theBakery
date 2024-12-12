<?php
    // Configuramos el namespace
    namespace theBakery\public\src;

    // Incluimos el archivo de dulce
    require_once("Dulce.php");

    // Recogemos los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];

    // Actualizamos los datos del dulce en la base de datos
    $nombreDulce = str_replace(" ", "", $nombre);
    $dulce = new Dulce($nombreDulce, $precio, $descripcion, $categoria);
    $dulce->updateDulce($id);

    // Redirigimos a la lista de dulces
    header('Location: ../mainAdmin.php');
    exit;
?>
