<?php
    // Configuramos el namespace
    namespace theBakery\public;
    
    // Usamos la ruta de el namespace
    use theBakery\public\src\ConexionDB;

    // Incluimos el archivo para la conexión a la base de datos
    require_once("src/ConexionDB.php");

    // Verificamos si el formulario ha sido enviado utilizando el método POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Verificamos si cada campo está presente en la solicitud POST. Si no está, asignamos un valor por defecto
        $name = isset($_POST['name']) ? $_POST['name'] : "Error"; // Obtenemos el nombre del usuario
        $username = isset($_POST['username']) ? $_POST['username'] : "Error"; // Obtenemos el nombre de usuario
        $mail = isset($_POST['mail']) ? $_POST['mail'] : "Error"; // Obtenemos el correo electrónico
        $password = isset($_POST['password']) ? $_POST['password'] : "Error"; // Obtenemos la contraseña

        // Imprimimos los datos obtenidos para depuración
        echo("<script>console.log($name);</script>");
        echo("<script>console.log($username);</script>");
        echo("<script>console.log($mail);</script>");
        echo("<script>console.log($password);</script>");

    
        // Creamos una instancia de la conexión a la base de datos usando el patrón Singleton
        $conexionDB = ConexionDB::obtenerInstancia();
        $conexion = $conexionDB->obtenerConexion();

        // Preparamos la consulta SQL para insertar un nuevo usuario en la base de datos
        $query = $conexion->prepare("INSERT INTO usuarios (name, username, password, email, rol) VALUES
        (?, ?, ?, ?, 'cliente');"); // Ponemos "?" para evitar las inyecciones SQL


        $password = trim($_POST['password']); // Usamos "trim" para quitar los espacios
        // Usamos la función "password_hash" para encriptar la contraseña antes de guardarla en la base de datos
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
        $query->bindParam(':password', $hashedPassword);

        // Ejecutamos la consulta para insertar los datos en la base de datos
        if ($query->execute([$name, $username, $hashedPassword, $mail])) {
            // Si la inserción es exitosa, mostramos un mensaje y redirigimos a la página de login
            echo("<script>alert('Datos guardados correctamente');</script>");
            header('Location: index.php');
            exit();
        } else {
            // Si ocurre un error al insertar, mostramos un mensaje y redirigimos a la página de registro
            echo("<script>alert('Datos no guardados');</script>");
            header('Location: registerForm.php');
            exit();
        }
    }
?>