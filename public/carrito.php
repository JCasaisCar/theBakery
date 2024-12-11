<?php
    // Configuramos el namespace
    namespace theBakery\public;

    // Usamos una ruta de el namespace y el "PDO"
    use PDO;
    use theBakery\public\src\ConexionDB;

    // Incluimos el archivo para la conexión a la base de datos
    require_once("src/ConexionDB.php");

    // Hacemos esta función para leer un elemento de un dulce en la base de datos
    function readDulce($datoAObtener, $nombreCookie) {
        // Creamos una instancia de la conexión a la base de datos usando el patrón Singleton
        $conexionDB = ConexionDB::obtenerInstancia();
        $conexion = $conexionDB->obtenerConexion();

        // Preparamos la consulta SQL para seleccionar un dulce
        $query = $conexion->prepare("SELECT $datoAObtener FROM dulces WHERE nombre=?;"); // Ponemos "?" para evitar la inyección SQL

        // Comprobamos y ejecutamos la consulta para insertar los datos en la base de datos
        if ($query->execute([$nombreCookie])) {
                // Obtenemos el resultado de la consulta
                $resultado = $query->fetch(PDO::FETCH_ASSOC); // Usamos "PDO::FETCH_ASSOC" para que nos devuelva un array clave valor
                
                // Verificamos si el resultado no es nulo
                if ($resultado) {
                        echo("<script>console.log('Los datos de el dato $datoAObtener de la cookie $nombreCookie se han leído correctamente')</script>");
                        echo("<script>console.log('$resultado[$datoAObtener]');</script>");
                        // Devolvemos el valor de un dato de el resultado
                        return $resultado[$datoAObtener];
                } else {
                        echo("<script>console.log('Los datos de el dato $datoAObtener de la cookie $nombreCookie no se han leído')</script>");
                        return "";
                }
        } else {
                echo("<script>console.log('Fallo en la consulta de los datos de el dato $datoAObtener de la cookie $nombreCookie')</script>");
                return "";
        }
    } 


    // Array para almacenar los productos
    $productos = [];

    // Verificamos si existen cookies
    if (isset($_COOKIE)) {
        // Recorremos todas las cookies
        foreach ($_COOKIE as $nombre => $cantidad) {
            echo("<script>console.log('foreach $nombre');</script>");
            // Verificamos si no son cookies de el usurio debido a que solo queremos que lo haga con las de dulces
            if ($nombre!="idCliente" && $nombre!="rol" && $nombre!="username") {
                // Verificamos si la cantidad es numérica y si lo es la parseamos a float, sino la ponemos en 0 para que no de fallos
                if (is_numeric($cantidad)) {
                    $cantidad = (float)$cantidad;
                } else {
                    $cantidad = 0;
                }

                 // Usamos "(float)" para parsear a float y usamos "readDulce" para sacar los parámetros
                $precioSinIVA = (float)readDulce("precio", $nombre);
                $iva = (float)readDulce("iva", $nombre);
                $categoria = readDulce("categoria", $nombre);
                $precioConIVA = ($precioSinIVA * $iva) / 100 + $precioSinIVA;
                $totalSinIVA = $cantidad * $precioSinIVA;
                $totalConIVA = $cantidad * $precioConIVA;

                // Agregamos el producto al array
                $productos[] = [
                    'categoria' => $categoria,
                    'nombre' => $nombre,
                    'cantidad' => $cantidad,
                    'precioSinIVA' => $precioSinIVA,
                    'precioConIVA' => $precioConIVA,
                    'totalSinIVA' => $totalSinIVA,
                    'totalConIVA' => $totalConIVA
                ];
            }
        }

        // Calculamos el total general de todos los "totalConIVA" con "array_sum" para sumarlos y "array_column" para qe coja los valores de la columna "totalConIVA" 
        $totalGeneralConIVA = array_sum(array_column($productos, "totalConIVA"));
        $productos[] = [
            'categoria' => "",
            'nombre' => "Total General",
            'cantidad' => "",
            'precioSinIVA' => "",
            'precioConIVA' => "",
            'totalSinIVA' => "",
            'total' => $totalGeneralConIVA
        ];       
    }

    echo("
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Tabla Dinámica</title>
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    </head>
    <body>

        <div class='container mt-4'>
            <h2>Productos</h2>
            <div id='tabla'></div> <!-- Aquí se insertará la tabla dinámica -->
        </div>

        <script>
            // Pasamos el array PHP a JavaScript usando json_encode
            let productos = " . json_encode($productos) . ";
            console.log(productos);  // Para verificar que el array se pasó correctamente a JavaScript
        </script>

        <script src='js/carrito.js'></script> <!-- Para ejecutar aqui el 'carrito.js' -->

        <form id='guardarForm' method='POST' action='guardarDatosCarritoBBDD.php'>
                <input type='hidden' name='productos' id='productosInput'>
                <button type='submit' class='btn btn-success btn-lg btn-block mt-4'>
                    <i class='fas fa-save'></i> Guardar en la Base de Datos
                </button>
            </form>

            <!-- Botón de ir atrás -->
            <div class='d-flex justify-content-end mt-4'>
                <a href='mainCliente.php' class='btn btn-warning'>
                    <i class='fas fa-arrow-left'></i> Ir atrás
                </a>
            </div>
        </div>

        <script>
        // Asignamos el array JSON al input hidden antes de enviar el formulario
            document.getElementById('guardarForm').addEventListener('submit', function () {
                document.getElementById('productosInput').value = JSON.stringify(productos);
            });
        </script>
    </body>
    </html>
    ");
?>