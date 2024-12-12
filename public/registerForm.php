<?php
    // Configuramos el namespace
    namespace theBakery\public;

    // Usamos la variable "$title" para asignar el título de la página a "registerForm"
    $title = "registerForm";

    // Incluimos el archivo para la cabecera de el "HTML"
    require_once("index1.php");
?>

<div class="container my-5">
    <!-- Creamos un formulario HTML que enviará los datos a "register.php" utilizando el método POST -->
     <!-- Usamos "onsubmit" para que cuando le demos al boton de "submit" antes de enviar los datos los valide con la función que hemos definido en js -->
    <form action="register.php" method="POST" class="w-50 mx-auto p-4 border rounded shadow-sm" onsubmit="return validarFormulario(this)">
        
        <!-- Usamos un contenedor para el campo de entrada del nombre -->
        <div class="mb-3">
            <!-- Usamos un "label" para describir el campo del nombre -->
            <label for="name" class="form-label">Nombre</label>
            <!-- Usamos un campo de entrada de tipo 'text' para el nombre con el atributo 'name' igual a 'name' -->
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Usamos otro contenedor para el campo de entrada del nombre de usuario -->
        <div class="mb-3">
            <!-- Usamos un "label" para describir el campo del nombre de usuario -->
            <label for="username" class="form-label">Nombre de Usuario</label>
            <!-- Usamos un campo de entrada de tipo 'text' para el nombre de usuario con el atributo 'username' igual a 'username' -->
            <input type="text" class="form-control" id="username" name="username" required>
        </div>

        <!-- Usamos otro contenedor para el campo de entrada del correo electrónico -->
        <div class="mb-3">
            <!-- Usamos un "label" para describir el campo del correo -->
            <label for="mail" class="form-label">Correo</label>
            <!-- Usamos un campo de entrada de tipo 'email' para el correo con el atributo 'mail' igual a 'mail' -->
            <input type="email" class="form-control" id="mail" name="mail" required>
        </div>

        <!-- Usamos otro contenedor para el campo de entrada de la contraseña -->
        <div class="mb-3">
            <!-- Usamos un "label" para describir el campo de la contraseña -->
            <label for="password" class="form-label">Contraseña</label>
            <!-- Usamos un campo de entrada de tipo 'password' para la contraseña con el atributo 'password' igual a 'password' -->
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <!-- Usamos un botón de tipo 'submit' para enviar el formulario -->
        <button type="submit" class="btn btn-primary w-100">Registrar</button>
    </form>

    <!-- Creamos un enlace que redirige a la página de login para los usuarios que ya se han registrado -->
    <div class="text-center mt-3">
        <h5>¿Ya estás registrado?</h5>
        <a class="link-offset-2 link-underline link-underline-opacity-0" href="index.php">Pincha aquí</a>
    </div>
</div>

<?php
    // Incluimos el archivo para el pie de página de el "HTML"
    require_once("index2.php");
?>