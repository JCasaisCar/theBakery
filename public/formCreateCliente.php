<?php
    // Configuramos el namespace
    namespace theBakery\public;

    // Configuración básica del formulario para dar de alta un nuevo cliente
    $title = "Crear Cliente";
    require_once("index1.php");
?>

    <div class="container my-5">
        <h1 class="text-center">Crear Cliente</h1>
        <form action="createCliente.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Cliente</button>
        </form>
    </div>

<?php require_once("index2.php"); ?>