<?php
    namespace theBakery\public;

    use theBakery\public\src\ConexionDB;
    use PDO;

    // Usamos la variable "$title" para asignar el título de la página a "mainCliente"
    $title = "mainCliente";

    require_once("index1.php");
    // Incluimos el archivo para la conexión a la base de datos
    require_once("src/ConexionDB.php");

    
    if (isset($_COOKIE['username'])) {
        $username = $_COOKIE['username'];
        echo("<h1>¡¡Bienvenid@ $username!!</h1>");
    } else {
        echo("No existe la cookie");
    }


    /*-- Tabla para carritos
CREATE TABLE IF NOT EXISTS carrito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idCliente INT NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (idCliente) REFERENCES clientes(id)
);*/

    // Establecemos una conexión a la base de datos utilizando el patrón Singleton
    $conexionDB = ConexionDB::obtenerInstancia();
    $conexion = $conexionDB->obtenerConexion();

   // Preparamos una consulta SQL para seleccionar el rol de un nombre de usuario en la base de datos
   $query = $conexion->prepare("SELECT id FROM usuarios WHERE username = ?");

   // Ejecutamos la consulta
   $query->execute([$username]);

   // Obtenemos el resultado de la consulta
   $resultado = $query->fetch(PDO::FETCH_ASSOC);

   if ($resultado) {
       $idCliente = $resultado['id'];
   }

   // Preparamos una consulta SQL para seleccionar el rol de un nombre de usuario en la base de datos
   $query1 = $conexion->prepare("INSERT INTO carrito (idCliente) VALUES (?);");

   // Ejecutamos la consulta
   if($query1->execute([$idCliente])) {
    echo("<script>console.log('Carrito para el cliente $idCliente creado');
    document.cookie = 'idCliente=$idCliente; path=/';
    </script>");
   } else {
    echo("<script>console.log('Carrito para el cliente $idCliente no creado');</script>");
   }




    echo("<h2><a onclick='cerrarSesion()'>Pincha aqui para cerrar la sesión</a></h2>");

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