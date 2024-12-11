<?php
    namespace theBakery\public;

    use theBakery\public\src\ConexionDB;
    use PDO;

    require_once("index1.php");
    // Incluimos el archivo para la conexión a la base de datos
    require_once("src/ConexionDB.php");

    // Comprobamos si la solicitud es del tipo POST, es decir, si se ha enviado el formulario de login
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Recogemos los datos enviados desde el formulario de login
        $username = $_POST['username'];
        // Usamos "trim" para quitar los espacios
        $password = trim($_POST['password']);


        // Establecemos una conexión a la base de datos utilizando el patrón Singleton
        $conexionDB = ConexionDB::obtenerInstancia();
        $conexion = $conexionDB->obtenerConexion();

        // Preparamos una consulta SQL para verificar si el nombre de usuario existe en la base de datos
        $query = $conexion->prepare("SELECT password FROM usuarios WHERE username = ?");
        
        // Ejecutamos la consulta
        $query->execute([$username]);

        // Obtenemos el resultado de la consulta
        $resultado = $query->fetch(PDO::FETCH_ASSOC);


        // Preparamos una consulta SQL para seleccionar el rol de un nombre de usuario en la base de datos
        $queryRol = $conexion->prepare("SELECT rol FROM usuarios WHERE username = ?");

        // Ejecutamos la consulta
        $queryRol->execute([$username]);

        // Obtenemos el resultado de la consulta
        $resultadoRol = $queryRol->fetch(PDO::FETCH_ASSOC);

        if ($resultadoRol) {
            $rol = $resultadoRol['rol'];
        }
        


        // Verificamos si se obtuvo un resultado
        if ($resultado) {
            // Si el usuario existe, comparamos la contraseña proporcionada con la almacenada en la base de datos
            // Usamos "password_verify" para verificar que la contraseña es correcta
            if (password_verify($password, $resultado['password'])) {
                echo "<script>
                    'use strict';
                    function getCookie(name) {
                        // Hacemos un array de cookies con el separador '; ' con '.split('; ')'
                        let cookies = document.cookie.split('; ');


                        // Recorremos todas las cookies con el 'for of' para que nos devuelva el contenido de cada una en cada posición de el array
                        for(let cookie of cookies) {
                            // Hacemos un array de el nombre y el valor de cada cookie separado por el '=' con '.split('=')'
                            let cookieArray = cookie.split('=');
                            let cookieName = cookieArray[0];
                            let cookieValue = cookieArray[1];


                            if(cookieName === name) {
                                // Si existe la cookie devolvemos su valor
                                return cookieValue;
                            } 
                        }

                        // Si no existe la cookie devolvemos null
                        return null;
                    }

                    document.cookie = 'username=$username; path=/';
                    document.cookie = 'rol=$rol; path=/';
                    if (getCookie('rol')) {
                        if (getCookie('rol')==='admin') {
                            window.location.href = 'mainAdmin.php';
                        } else {
                            window.location.href = 'mainCliente.php';
                        } 
                    }
                </script>";
                exit();
            } else {
                // Si la contraseña es incorrecta, mostramos un mensaje de error y ofrecemos un enlace para volver al login
                echo "El usuario existe pero la contraseña es incorrecta </br>
                <h2><a href='index.php'>Pincha aqui para volver al login</a></h2>";
            }
        } else {
            // Si el usuario no existe en la base de datos, mostramos un mensaje de error y un enlace para volver al login
            echo "Usuario o contraseña incorrecta </br>
            <h2><a href='005login.php'>Pincha aqui para volver al login</a></h2>";
        }
    }

    require_once("index2.php");
?>