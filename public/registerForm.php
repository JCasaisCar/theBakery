<?php
    namespace theBakery\public;

    // Usamos la variable "$title" para asignar el título de la página a "005registro"
    $title = "registerForm";

    // Usamos "require_once" para incluir el archivo "index1.php"
    require_once("index1.php");
?>

    <!-- Creamos un formulario HTML que enviará los datos a "006nuevoUsuario.php" utilizando el método POST -->
    <form action='register.php' method='POST'>
        
        <!-- Usamos un contenedor para el campo de entrada del nombre -->
        <div class='mb-3'>
            <!-- Usamos un "label" para describir el campo del nombre -->
            <label for='name' class='form-label'>Nombre</label>
            <!-- Usamos un campo de entrada de tipo 'text' para el nombre con el atributo 'name' igual a 'name' -->
            <input type='text' class='form-control' id='name' name='name' required>
        </div>

        <!-- Usamos otro contenedor para el campo de entrada del nombre de usuario -->
        <div class='mb-3'>
            <!-- Usamos un "label" para describir el campo del nombre de usuario -->
            <label for='username' class='form-label'>Nombre de Usuario</label>
            <!-- Usamos un campo de entrada de tipo 'text' para el nombre de usuario con el atributo 'name' igual a 'username' -->
            <input type='text' class='form-control' id='username' name='username' required>
        </div>

        <!-- Usamos otro contenedor para el campo de entrada del correo electrónico -->
        <div class='mb-3'>
            <!-- Usamos un "label" para describir el campo del correo -->
            <label for='mail' class='form-label'>Correo</label>
            <!-- Usamos un campo de entrada de tipo 'email' para el correo con el atributo 'name' igual a 'mail' -->
            <input type='email' class='form-control' id='mail' name='mail' required>
        </div>

        <!-- Usamos otro contenedor para el campo de entrada de la contraseña -->
        <div class='mb-3'>
            <!-- Usamos un "label" para describir el campo de la contraseña -->
            <label for='password' class='form-label'>Contraseña</label>
            <!-- Usamos un campo de entrada de tipo 'password' para la contraseña con el atributo 'name' igual a 'password' -->
            <input type='password' class='form-control' id='password' name='password' required>
        </div>

        <!-- Usamos un botón de tipo 'submit' para enviar el formulario -->
        <button type='submit' class='btn btn-primary'>Guardar Cambios</button>
    </form>

    <!-- Creamos un enlace que redirige a la página de login para los usuarios que ya se han registrado -->
    <h2>¿Ya estás registrado?<a class="link-offset-2 link-underline link-underline-opacity-0" href="index.php"> Pincha aquí</a></h2>

<?php
    // Usamos "require_once" para incluir el archivo "index2.php"
    require_once("index2.php");
?>