<?php
// Configuramos el namespace
namespace theBakery\public;

// Usamos una ruta de el namespace y el "PDO"
use PDO;
use theBakery\public\src\ConexionDB;

// Usamos la variable "$title" para asignar el título de la página a "mainAdmin"
$title = "mainAdmin";

// Incluimos el archivo para la cabecera de el "HTML"
require_once("index1.php");

// Si existe la cookie la guardamos y ponemos un texto de bienvenida, sino ponemos un texto de que no existe
if (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
    echo("<h1 class='text-center text-primary'>¡¡Bienvenid@ $username!!</h1>");
} else {
    echo("<p class='text-center text-danger'>No existe la cookie</p>");
}

echo("<div class='container my-5'>");

// Incluimos el archivo para la conexión a la base de datos
require_once("src/ConexionDB.php");

// Establecemos la conexión a la base de datos
$conexionDB = ConexionDB::obtenerInstancia();
$conexion = $conexionDB->obtenerConexion();

// Hacemos la consulta de el listado de clientes con "PDO::FETCH_ASSOC" en el resultado para que nos arroje un array con clave valor, la clave es el nombre de la columna en la base de datos
$queryClientes = $conexion->prepare("SELECT id, name, username, email FROM usuarios WHERE rol = 'cliente'");
$queryClientes->execute();
$clientes = $queryClientes->fetchAll(PDO::FETCH_ASSOC);

echo ("<h3 class='mb-4'>Listado de Clientes</h3>");
echo ("<table class='table table-striped'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Pedidos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>");

// Hacemos un "foreach" para recorrer el resultado de clientes     
foreach ($clientes as $cliente) {
    // Consultamos los pedidos de cada cliente con "PDO::FETCH_ASSOC" en el resultado para que nos arroje un array con clave valor, la clave es el nombre de la columna en la base de datos
    $queryPedidos = $conexion->prepare("SELECT idPedido, fechaPedido, total FROM pedidos WHERE idCliente = ?");
    $queryPedidos->execute([$cliente['id']]);
    $pedidos = $queryPedidos->fetchAll(PDO::FETCH_ASSOC);

    // Mostramos los datos del cliente
    echo ("<tr>
            <td>{$cliente['id']}</td>
            <td>{$cliente['name']}</td>
            <td>{$cliente['username']}</td>
            <td>{$cliente['email']}</td>
            <td>");

    // Si el cliente tiene pedidos, los mostramos con "count" para saber el número de pedidos, sino decimos que no hay pedidos
    if (count($pedidos) > 0) {
        echo ("<ul class='list-group'>");
        foreach ($pedidos as $pedido) {
            echo ("<li class='list-group-item'>
                    Pedido ID: {$pedido['idPedido']}, 
                    Fecha: {$pedido['fechaPedido']}, 
                    Total: {$pedido['total']}
                </li>");
        }
        echo ("</ul>");
    } else {
        echo ("<span class='badge bg-secondary'>No hay pedidos</span>");
    }

    // Agregamos los botones de actualizar y eliminar cliente
    echo ("</td>
            <td>
                <a href='formUpdateCliente.php?id={$cliente['id']}' class='btn btn-primary btn-sm'>Actualizar</a>
                <button class='btn btn-danger btn-sm' onclick='confirmarEliminar({$cliente['id']})'>Eliminar</button>
            </td>
        </tr>");
}
echo ("</tbody></table>");

// Agregamos un botón para dar de alta un nuevo cliente
echo ("<div class='text-end'>
        <a href='formCreateCliente.php' class='btn btn-success'>Dar de Alta Nuevo Cliente</a>
    </div>");

// Consultamos el listado de dulces (productos) con "PDO::FETCH_ASSOC" en el resultado para que nos arroje un array con clave valor, la clave es el nombre de la columna en la base de datos
$queryDulces = $conexion->prepare("SELECT id, nombre, precio, categoria FROM dulces");
$queryDulces->execute();
$dulces = $queryDulces->fetchAll(PDO::FETCH_ASSOC);

echo ("<h3 class='mb-4'>Listado de Dulces</h3>");
echo ("<table class='table table-striped'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>PrecioSinIVA</th>
                <th>Categoría</th>
            </tr>
        </thead>
        <tbody>");

// Hacemos un "foreach" para recorrer el resultado de dulces   
foreach ($dulces as $dulce) {
    echo ("<tr>
            <td>{$dulce['id']}</td>
            <td>{$dulce['nombre']}</td>
            <td>{$dulce['precio']}</td>
            <td>{$dulce['categoria']}</td>
        </tr>");
}
echo ("</tbody></table>");

echo("<div class='text-center mt-4'>
        <button class='btn btn-danger' onclick='cerrarSesion()'>Cerrar sesión</button>
    </div>");
echo("</div>");

// Incluimos el archivo para el pie de página de el "HTML"
require_once("index2.php");
?>

<script>
// Hacemos esta función para usarla para el botón de cerrar sesión
function cerrarSesion() {
        // Obtenemos todas las cookies
        let cookies = document.cookie.split("; ");
        
        // Recorremos cada cookie y la eliminamos
        for (let cookie of cookies) {
            // Obtenemos el nombre de la cookie (antes del '=')
            let cookieName = cookie.split("=")[0];
            
            // Establecemos la cookie con una fecha de expiración en el pasado para eliminarla
            document.cookie = cookieName + "=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }

        // Redirigimos al usuario a la página de login
        window.location.href = 'index.php';
}

// Función para confirmar eliminación de un cliente
function confirmarEliminar(id) {
    if (confirm('¿Está seguro de que desea eliminar este cliente?')) {
        window.location.href = `removeCliente.php?id=${id}`;
    }
}
</script>
