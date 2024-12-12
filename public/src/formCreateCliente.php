<?php
    // Configuramos el namespace
    namespace theBakery\public\src;

    // Usamos la variable "$title" para asignar el título de la página a "Crear Dulce"
    $title = "Crear Cliente";

    // Incluimos el archivo para la cabecera de el "HTML"
    require_once("../index1.php");
?>

<div class="container my-5">
    <h1 class="text-center">Crear Cliente</h1>
    <!-- Usamos "onsubmit" para que cuando le demos al boton de "submit" antes de enviar los datos los valide con la función que hemos definido en js -->
    <form action="createCliente.php" method="POST" onsubmit="return validarFormulario(this)">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="mail" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="mail" name="mail" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Cliente</button>
    </form>
</div>

<!--Incluimos el archivo para la pie de el "HTML"-->
<?php require_once("../index2.php"); ?>