<?php 
    // Configuramos el namespace
    namespace theBakery\public;

    // Usamos una ruta de el namespace y el "Exception"
    use Exception;
    use theBakery\public\src\ConexionDB;

    // Incluimos el archivo para la conexión a la base de datos
    require_once("src/ConexionDB.php");

    // Comprobamos si la solicitud es del tipo POST, es decir, si se ha enviado bien el carrito
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verificamos si existe la cookie
        if (isset($_POST['productos'])) {
            // Decodificamos el "json" en un array
            $productos = json_decode($_POST['productos'], true);

            // Con "is_array" confirmamos si es un array y con "count" contamos el número de productor
            if (is_array($productos) && count($productos) > 0) {
                // Verificamos si existe la cookie
                if (isset($_COOKIE['idCliente'])) {
                    $idCliente = $_COOKIE['idCliente'];
                    echo ("<script>console.log('Cookie idCliente: {$idCliente}');</script>");
                } else {
                    exit('Error: No se encontró la cookie del cliente.');
                }

                $total = 0; // Total del pedido

                // Hacemos un "foreach" para recorrer el resultado de productos
                foreach ($productos as $producto) {
                    if (isset($producto['totalConIVA'])) {
                        $total += $producto['totalConIVA'];
                    }
                }

                // Establecemos una conexión a la base de datos utilizando el patrón Singleton
                $conexionDB = ConexionDB::obtenerInstancia();
                $conexion = $conexionDB->obtenerConexion();

                try {
                    // Hacemos una consulta para insertar datos en la tabla "pedidos"
                    $queryPedido = $conexion->prepare("
                        INSERT INTO pedidos (idCliente, total)
                        VALUES (?, ?)
                    ");

                    $queryPedido->execute([$idCliente, $total]);
                    $idPedido = $conexion->lastInsertId(); // Obtenemos el ID del pedido recién creado con "lastInsertId"

                    // Hacemos una consulta para insertar datos en la tabla "detalles_pedido"
                    $queryDetalle = $conexion->prepare("
                        INSERT INTO detalles_pedido (idPedido, nombreProducto, cantidad, precioUnitario, subtotal)
                        VALUES (?, ?, ?, ?, ?)
                    ");

                    // Hacemos un "foreach" para recorrer el resultado de productos
                    foreach ($productos as $producto) {
                        // Verificamos si los valores no son nulos
                        if (isset($producto['nombre'], $producto['cantidad'], $producto['precioConIVA'], $producto['totalConIVA'])) {
                            // Ejecutamos la consulta
                            $queryDetalle->execute([
                                $idPedido,
                                $producto['nombre'],
                                $producto['cantidad'],
                                $producto['precioConIVA'],
                                $producto['totalConIVA']
                            ]);
                        }
                    }

                
                    echo ("<script>alert('Pedido guardado correctamente.');
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
                    window.location.href = 'index.php';</script>");
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