<?php 
namespace theBakery\public;

use PDO;
use Exception;
use theBakery\public\src\ConexionDB;

require_once("src/ConexionDB.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['productos'])) {
        $productos = json_decode($_POST['productos'], true);

        if (is_array($productos) && count($productos) > 0) {
            if (isset($_COOKIE['idCliente'])) {
                $idCliente = $_COOKIE['idCliente'];
                echo "<script>console.log('Cookie idCliente: {$idCliente}');</script>";
            } else {
                exit('Error: No se encontró la cookie del cliente.');
            }

            $total = 0; // Total del pedido
            foreach ($productos as $producto) {
                if (isset($producto['totalConIVA'])) {
                    $total += $producto['totalConIVA'];
                }
            }

            $conexionDB = ConexionDB::obtenerInstancia();
            $conexion = $conexionDB->obtenerConexion();

            try {
        

                // Insertar en la tabla `pedidos`
                $queryPedido = $conexion->prepare("
                    INSERT INTO pedidos (idCliente, total)
                    VALUES (?, ?)
                ");
                $queryPedido->execute([$idCliente, $total]);
                $idPedido = $conexion->lastInsertId(); // Obtener el ID del pedido recién creado

                // Insertar en la tabla `detalles_pedido`
                $queryDetalle = $conexion->prepare("
                    INSERT INTO detalles_pedido (idPedido, nombreProducto, cantidad, precioUnitario, subtotal)
                    VALUES (?, ?, ?, ?, ?)
                ");

                foreach ($productos as $producto) {
                    if (isset($producto['nombre'], $producto['cantidad'], $producto['precioConIVA'], $producto['totalConIVA'])) {
                        $queryDetalle->execute([
                            $idPedido,
                            $producto['nombre'],
                            $producto['cantidad'],
                            $producto['precioConIVA'],
                            $producto['totalConIVA']
                        ]);
                    }
                }

            

                echo "<script>alert('Pedido guardado correctamente.');
                // Obtenemos todas las cookies
                let cookies = document.cookie.split('; ');
                
                // Recorremos cada cookie y la eliminamos
                for (let cookie of cookies) {
                    // Obtenemos el nombre de la cookie (antes del '=')
                    let cookieName = cookie.split('=')[0];
                    
                    // Establecemos la cookie con una fecha de expiración en el pasado para eliminarla
                    document.cookie = cookieName + '=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
                }


                // Redirigimos al usuario a la página de login
                window.location.href = 'index.php';</script>";
            } catch (Exception $e) {
                $conexion->rollBack();
                exit('Error al guardar el pedido: ' . $e->getMessage());
            }
        } else {
            exit('Error: No se recibieron productos válidos.');
        }
    } else {
        exit('Error: No se recibieron datos del carrito.');
    }
} else {
    exit('Error: Método de solicitud no válido.');
}
?>

