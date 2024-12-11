<?php
namespace theBakery\public;
use PDO;
use theBakery\public\src\ConexionDB;

$title = "mainAdmin";

require_once("index1.php");

if (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
    echo("<h1 class='text-center text-primary'>¡¡Bienvenid@ $username!!</h1>");
} else {
    echo("<p class='text-center text-danger'>No existe la cookie</p>");
}

echo("<div class='container my-5'>");

// Establecemos la conexión a la base de datos
require_once("src/ConexionDB.php");
$conexionDB = ConexionDB::obtenerInstancia();
$conexion = $conexionDB->obtenerConexion();

// Listado de clientes
$queryClientes = $conexion->prepare("SELECT id, name, username, email FROM usuarios WHERE rol = 'cliente'");
$queryClientes->execute();
$clientes = $queryClientes->fetchAll(PDO::FETCH_ASSOC);

echo "<h3 class='mb-4'>Listado de Clientes</h3>";
echo "<table class='table table-striped'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>  <!-- Nueva columna para el usuario -->
                <th>Email</th>
                <th>Pedidos</th>
            </tr>
        </thead>
        <tbody>";
foreach ($clientes as $cliente) {
    // Consulta los pedidos de cada cliente
    $queryPedidos = $conexion->prepare("SELECT idPedido, fechaPedido, total FROM pedidos WHERE idCliente = ?");
    $queryPedidos->execute([$cliente['id']]);
    $pedidos = $queryPedidos->fetchAll(PDO::FETCH_ASSOC);

    // Muestra los datos del cliente
    echo "<tr>
            <td>{$cliente['id']}</td>
            <td>{$cliente['name']}</td>
            <td>{$cliente['username']}</td>  <!-- Mostrar el nombre de usuario -->
            <td>{$cliente['email']}</td>
            <td>";
    
    // Si el cliente tiene pedidos, los mostramos
    if (count($pedidos) > 0) {
        echo "<ul class='list-group'>";
        foreach ($pedidos as $pedido) {
            echo "<li class='list-group-item'>
                    Pedido ID: {$pedido['idPedido']}, 
                    Fecha: {$pedido['fechaPedido']}, 
                    Total: {$pedido['total']}
                  </li>";
        }
        echo "</ul>";
    } else {
        echo "<span class='badge bg-secondary'>No hay pedidos</span>";
    }

    echo "</td></tr>";
}
echo "</tbody></table>";

// Listado de dulces (productos)
$queryDulces = $conexion->prepare("SELECT id, nombre, precio, categoria FROM dulces");
$queryDulces->execute();
$dulces = $queryDulces->fetchAll(PDO::FETCH_ASSOC);

echo "<h3 class='mb-4'>Listado de Dulces</h3>";
echo "<table class='table table-striped'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Categoría</th>
            </tr>
        </thead>
        <tbody>";
foreach ($dulces as $dulce) {
    echo "<tr>
            <td>{$dulce['id']}</td>
            <td>{$dulce['nombre']}</td>
            <td>{$dulce['precio']}</td>
            <td>{$dulce['categoria']}</td>
          </tr>";
}
echo "</tbody></table>";

echo("<div class='text-center mt-4'>
        <button class='btn btn-danger' onclick='cerrarSesion()'>Cerrar sesión</button>
      </div>");
echo("</div>");

require_once("index2.php");
?>

<script>
    function cerrarSesion() {
        // Eliminamos las cookies de sesión
        document.cookie = 'username=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
        document.cookie = 'rol=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';

        // Redirigimos al usuario a la página de login
        window.location.href = 'index.php';
    }
</script>
