<?php
    namespace theBakery\public;

    use theBakery\public\src\ConexionDB;
    use PDO;

    use theBakery\public\src\Bollo;
    use theBakery\public\src\Tarta;
    use theBakery\public\src\Chocolate;

    // Incluimos los archivos necesarios
    require_once("src/Bollo.php");
    require_once("src/Tarta.php");
    require_once("src/Chocolate.php");

    // Bollo
    $nombreBollo = "Croissant";
    $nombreBolloSinEspacios = str_replace(" ", "", $nombreBollo);
    $bollo = new Bollo($nombreBolloSinEspacios, 1.20, "Bollo relleno de chocolate", "Bollos", "Chocolate");
    $bollo->deleteAllDulce(); // Eliminar todos los dulces
    $bollo->createDulce(); // Probamos el método "create"

    // Chocolate
    $nombreChocolate = "Barra De Chocolate";
    $nombreChocolateSinEspacios = str_replace(" ", "", $nombreChocolate);
    $chocolate = new Chocolate($nombreChocolateSinEspacios, 2.50, "Chocolate con leche y almendras", "Chocolates", 10, 20);
    $chocolate->createDulce(); // Probamos el método "create"

    // Tarta
    $nombreTarta = "Tarta De Queso";
    $nombreTartaSinEspacios = str_replace(" ", "", $nombreTarta);
    $tarta = new Tarta($nombreTartaSinEspacios, 15.00, "Deliciosa tarta de queso al horno", "Tartas", ["chocolate", "galleta"], 2, 4, 20);
    $tarta->createDulce(); // Probamos el método "create"

    // Con "readAll" sacamos la lista de dulces
    $arrayDulces = $bollo->readAllDulce();
    
    // Usamos la variable "$title" para asignar el título de la página a "mainCliente"
    $title = "mainCliente";

    require_once("index1.php");
    // Incluimos el archivo para la conexión a la base de datos
    require_once("src/ConexionDB.php");

    $username = "";
    
    if (isset($_COOKIE['username'])) {
        $username = $_COOKIE['username'];
        echo("<h1 class='text-center text-primary'>¡¡Bienvenid@ $username!!</h1>");
    } else {
        echo("<p class='text-center text-danger'>No existe la cookie</p>");
    }

    // Establecemos una conexión a la base de datos utilizando el patrón Singleton
    $conexionDB = ConexionDB::obtenerInstancia();
    $conexion = $conexionDB->obtenerConexion();

   // Preparamos una consulta SQL para seleccionar el rol de un nombre de usuario en la base de datos
   $query = $conexion->prepare("SELECT id FROM usuarios WHERE username = ?");

   if ($username !== "") {
        // Ejecutamos la consulta
        $query->execute([$username]);
   }

   // Obtenemos el resultado de la consulta
   $resultado = $query->fetch(PDO::FETCH_ASSOC);

   if ($resultado) {
       $idCliente = $resultado['id'];

       echo("<script>
        document.cookie = 'idCliente=$idCliente; path=/';
        </script>");
   }

   // Botón de carrito
   echo '<div class="d-flex justify-content-end p-3">
   <a href="carrito.php" class="btn btn-primary">
       <i class="bi bi-cart"></i> Ir al Carrito
   </a>
    </div>';

   // Mostrar tabla de productos
   echo '<div class="container mt-4">
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Categoría</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($arrayDulces as $dulce) {
    echo '<tr>
            <td>' . htmlspecialchars($dulce['categoria']) . '</td>
            <td>' . htmlspecialchars($dulce['nombre']) . '</td>
            <td>' . number_format($dulce['precio'], 2) . ' €</td>
            <td>' . htmlspecialchars($dulce['descripcion']) . '</td>
            <td>
                <button class="btn btn-success" onclick="agregarAlCarrito(\'' . htmlspecialchars($dulce['nombre']) . '\')">
                    Añadir al carrito
                </button>
            </td>
        </tr>';
    }

    echo '    </tbody>
    </table>
    </div>';

    echo("<h2 class='text-center'><button class='btn btn-danger' onclick='cerrarSesion()'>Cerrar sesión</button></h2>");

    require_once("index2.php");
?>


<script>
    function cerrarSesion() {
        
        // Obtenemos todas las cookies
        let cookies = document.cookie.split("; ");
        
        // Recorremos cada cookie y la eliminamos
        for (let cookie of cookies) {
            // Obtenemos el nombre de la cookie (antes del '=')
            let cookieName = cookie.split("=")[0];
            
            // Establecemos la cookie con una fecha de expiración en el pasado para eliminarla
            document.cookie = cookieName + "=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }

        // Redirigimos al usuario a la página de login
        window.location.href = 'index.php';
    }

    function getCookie(name) {
        // Hacemos un array de cookies con el separador "; " con ".split("; ")"
        let cookies = document.cookie.split("; ");
        
        // Recorremos todas las cookies con el "for of" para que nos devuelva el contenido de cada una en cada posición del array
        for (let cookie of cookies) {
            // Hacemos un array de el nombre y el valor de cada cookie separado por el "=" con ".split("=")"
            let cookieArray = cookie.split("=");
            let cookieName = cookieArray[0];
            let cookieValue = cookieArray[1];

            if (cookieName === name) {
                // Si existe la cookie devolvemos su valor
                return cookieValue;
            } 
        }

        // Si no existe la cookie devolvemos null
        return null;
    }

    function agregarAlCarrito(producto) {
        // Obtenemos el valor actual de la cookie para el producto específico
        let cantidad = +getCookie(producto);
        
        if (cantidad) {
            // Si la cookie existe y es un número, sumamos 1
            cantidad = cantidad + 1;
        } else {
            // Si no existe, inicializamos el contador en 1
            cantidad = 1;
        }

        // Guardamos el nuevo valor de la cookie con la cantidad actualizada para este producto específico
        document.cookie = producto + '=' + cantidad + '; path=/';
    }
</script>
