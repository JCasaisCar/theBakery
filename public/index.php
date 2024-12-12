<?php
    // Configuramos el namespace
    namespace theBakery\public;

    // Usamos la variable "$title" para asignar el título de la página a "index"
    $title = "index";

    // Incluimos el archivo para la cabecera de el "HTML"
    require_once("index1.php");
?>

<div class="container my-5">
    <!-- Creamos un formulario HTML que enviará los datos a "login.php" utilizando el método POST -->
    <form action="login.php" method="POST" class="w-50 mx-auto p-4 border rounded shadow-sm">
        
        <!-- Usamos un contenedor para el campo de entrada del nombre de usuario -->
        <div class="mb-3">
            <!-- Usamos un "label" para describir el nombre de usuario -->
            <label for="username" class="form-label">Nombre de Usuario</label>
            <!-- Usamos un campo de entrada de tipo 'text' para el correo con el atributo 'username' igual a 'username' -->
            <input type="text" class="form-control" id="username" name="username" required>
        </div>

        <!-- Usamos otro contenedor para el campo de entrada de la contraseña -->
        <div class="mb-3">
            <!-- Usamos un "label" para describir el campo de la contraseña -->
            <label for="password" class="form-label">Contraseña</label>
            <!-- Usamos un campo de entrada de tipo 'password' para la contraseña con el atributo 'password' igual a 'password' -->
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <!-- Usamos un botón de tipo 'submit' para enviar el formulario -->
        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
    </form>

    <!-- Creamos un enlace que redirige a la página de registro para los usuarios que no se han registrado -->
    <div class="text-center mt-3">
        <h5>¿No estás registrado?</h5>
        <a class="link-offset-2 link-underline link-underline-opacity-0" href="registerForm.php">Pincha aquí</a>
    </div>
</div>

<?php
    // Incluimos el archivo para el pie de página de el "HTML"
    require_once("index2.php");
?>



<script>
    // Ejecutamos la función para eliminar las cookies cuando se carga la página con "window.onload"
    window.onload = function() {
        eliminarCookies();
    };

    // Hacemos esta función para eliminar todas las cookies
    function eliminarCookies() {
            // Obtenemos todas las cookies
            let cookies = document.cookie.split("; ");
            
            // Recorremos cada cookie y la eliminamos
            for (let cookie of cookies) {
                // Obtenemos el nombre de la cookie (antes del '=')
                let cookieName = cookie.split("=")[0];
                
                // Establecemos la cookie con una fecha de expiración en el pasado para eliminarla
                document.cookie = cookieName + "=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT";
            }
    }
</script>