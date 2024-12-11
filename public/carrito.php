<?php
namespace theBakery\public;

use PDO;
use theBakery\public\src\ConexionDB;

// Usamos "require_once" para incluir el archivo de conexión a la base de datos
require_once("src/ConexionDB.php");

function readDulce($datoAObtener, $nombreCookie) {
    // Creamos una instancia de la conexión a la base de datos usando el patrón Singleton
    $conexionDB = ConexionDB::obtenerInstancia();
    $conexion = $conexionDB->obtenerConexion();

    // Preparamos la consulta SQL para seleccionar un dulce por su id en la base de datos
    $query = $conexion->prepare("SELECT $datoAObtener FROM dulces WHERE nombre=?;"); // Ponemos "?" para evitar la inyección SQL

    // Ejecutamos la consulta para insertar los datos en la base de datos
    if ($query->execute([$nombreCookie])) {
            // Obtenemos el resultado de la consulta
            $resultado = $query->fetch(PDO::FETCH_ASSOC); // Usamos "PDO::FETCH_ASSOC" para que nos devuelva un array clave valor
            if ($resultado) {
                    echo("<script>console.log('Los datos de el dato $datoAObtener de la cookie $nombreCookie se han leído correctamente')</script>");
                    echo("<script>console.log('$resultado[$datoAObtener]');</script>");
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


//Falla aqui hace el primero pero los otros no los hace
// Verificar si existen cookies
if (isset($_COOKIE)) {
    // Recorrer todas las cookies
    foreach ($_COOKIE as $nombre => $cantidad) {
        echo("<script>console.log('foreach $nombre');</script>");
        // Aquí puedes hacer la consulta a la base de datos para obtener los otros valores
        // como 'categoria', 'precioSinIVA', 'precioConIVA', 'totalSinIVA' y 'totalConIVA'.
        if ($nombre!="idCliente" && $nombre!="rol" && $nombre!="username") {
            $cantidad = is_numeric($cantidad) ? (float)$cantidad : 0;

            
            $precioSinIVA = (float)readDulce("precio", $nombre);  // Convertir a float
            $iva = (float)readDulce("iva", $nombre);  // Convertir a float


            // Aquí se simulan los valores para la demostración
            $categoria = readDulce("categoria", $nombre);  // Simulación
            
            $precioConIVA = ($precioSinIVA * $iva) / 100 + $precioSinIVA;
            $totalSinIVA = $cantidad * $precioSinIVA;
            $totalConIVA = $cantidad * $precioConIVA;


            // Agregar el producto al array
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
    // Calcular el total general de todos los `totalConIVA`
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
</head>
<body>

    <div class='container mt-4'>
        <h2>Productos</h2>
        <div id='tabla'></div> <!-- Aquí se insertará la tabla dinámica -->
    </div>

    <script>
        // Pasamos el array PHP a JavaScript usando json_encode
        let productos = " . json_encode($productos) . ";
        console.log(productos);  // Aquí puedes verificar que el array se pasó correctamente a JavaScript
    </script>

    <script src='js/carrito.js'></script> <!-- carrito.js -->

     <form id='guardarForm' method='POST' action='guardarDatosCarritoBBDD.php'>
            <input type='hidden' name='productos' id='productosInput'>
            <button type='submit' class='btn btn-primary mt-3'>Guardar en la Base de Datos</button>
    </form>

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
