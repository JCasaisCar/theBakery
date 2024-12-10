<?php
    namespace theBakery\public;

    use theBakery\public\src\ConexionDB;
    use PDO;

    require_once("index1.php");

    // Comprobamos si la solicitud es del tipo POST, es decir, si se ha enviado el formulario de login
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Recogemos los datos enviados desde el formulario de login
        $username = $_POST['username'];
        // Usamos "trim" para quitar los espacios
        $password = trim($_POST['password']);

        

        // Incluimos el archivo para la conexión a la base de datos
        require_once("src/ConexionDB.php");

        // Establecemos una conexión a la base de datos utilizando el patrón Singleton
        $conexionDB = ConexionDB::obtenerInstancia();
        $conexion = $conexionDB->obtenerConexion();

        // Preparamos una consulta SQL para verificar si el nombre de usuario existe en la base de datos
        $query = $conexion->prepare("SELECT password FROM usuarios WHERE username = ?");
        
        // Ejecutamos la consulta
        $query->execute([$username]);

        // Obtenemos el resultado de la consulta
        $resultado = $query->fetch(PDO::FETCH_ASSOC);

        // Verificamos si se obtuvo un resultado
        if ($resultado) {
            // Si el usuario existe, comparamos la contraseña proporcionada con la almacenada en la base de datos
            // Usamos "password_verify" para verificar que la contraseña es correcta
            if (password_verify($password, $resultado['password'])) {
                echo "<script>
                    alert('¡¡Bienvenido $username!!');
                    window.location.href = 'main.php';
                </script>";
                exit();
            } else {
                // Si la contraseña es incorrecta, mostramos un mensaje de error y ofrecemos un enlace para volver al login
                echo "Contraseña incorrecta </br>
                <h2><a href='index.php'>Pincha aqui para volver al login</a></h2>";
            }
        } else {
            // Si el usuario no existe en la base de datos, mostramos un mensaje de error y un enlace para volver al login
            echo "Usuario incorrecto </br>
            <h2><a href='005login.php'>Pincha aqui para volver al login</a></h2>";
        }
    }

    require_once("index2.php");
?>