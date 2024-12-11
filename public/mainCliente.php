<?php
    // Configuramos el namespace
    namespace theBakery\public;

    // Usamos las rutas de el namespace y el "PDO"
    use theBakery\public\src\ConexionDB;
    use PDO;
    use theBakery\public\src\Bollo;
    use theBakery\public\src\Tarta;
    use theBakery\public\src\Chocolate;
    use theBakery\public\src\Cliente;

    // Incluimos los archivos necesarios
    require_once("src/Bollo.php");
    require_once("src/Tarta.php");
    require_once("src/Chocolate.php");
    require_once("src/Cliente.php");

    // Añadimos un bollo
    $nombreBollo = "Croissant";
    // Usamos "str_replace" para quitar los espacios
    $nombreBolloSinEspacios = str_replace(" ", "", $nombreBollo);
    $bollo = new Bollo($nombreBolloSinEspacios, 1.20, "Bollo relleno de chocolate", "Bollos", "Chocolate");
    $bollo->deleteAllDulce(); // Eliminar todos los dulces antes de añadir lo primero para que no se repitan
    $bollo->createDulce();

    // Añadimos un chocolate
    $nombreChocolate = "Barra De Chocolate";
    // Usamos "str_replace" para quitar los espacios
    $nombreChocolateSinEspacios = str_replace(" ", "", $nombreChocolate);
    $chocolate = new Chocolate($nombreChocolateSinEspacios, 2.50, "Chocolate con leche y almendras", "Chocolates", 10, 20);
    $chocolate->createDulce(); 

    // Añadimos una tarta
    $nombreTarta = "Tarta De Queso";
    // Usamos "str_replace" para quitar los espacios
    $nombreTartaSinEspacios = str_replace(" ", "", $nombreTarta);
    $tarta = new Tarta($nombreTartaSinEspacios, 15.00, "Deliciosa tarta de queso al horno", "Tartas", ["chocolate", "galleta"], 2, 4, 20);
    $tarta->createDulce(); 

    // Con "readAll" sacamos la lista de dulces
    $arrayDulces = $bollo->readAllDulce();
    
    // Usamos la variable "$title" para asignar el título de la página a "mainCliente"
    $title = "mainCliente";

    // Incluimos el archivo para la cabecera de el "HTML"
    require_once("index1.php");
    // Incluimos el archivo para la conexión a la base de datos
    require_once("src/ConexionDB.php");

    $username = "";
    
    // Si existe la cookie la guardamos y ponemos un texto de bienvenida, sino ponemos un texto de que no existe
    if (isset($_COOKIE['username'])) {
        $username = $_COOKIE['username'];
        echo("<h1 class='text-center text-primary'>¡¡Bienvenid@ $username!!</h1>");
    } else {
        echo("<p class='text-center text-danger'>No existe la cookie</p>");
    }

    // Establecemos una conexión a la base de datos utilizando el patrón Singleton
    $conexionDB = ConexionDB::obtenerInstancia();
    $conexion = $conexionDB->obtenerConexion();

   // Preparamos una consulta SQL para seleccionar el id de un nombre de usuario en la base de datos
   $query = $conexion->prepare("SELECT id FROM usuarios WHERE username = ?");

   // Si el usuario no esta vacío ejecutamos la consulta
   if ($username !== "") {
        $query->execute([$username]);
   }

   // Obtenemos el resultado de la consulta con "PDO::FETCH_ASSOC" en el resultado para que nos arroje un array con clave valor, la clave es el nombre de la columna en la base de datos
   $resultado = $query->fetch(PDO::FETCH_ASSOC);

   // Si el resultado no es nulo hacemos la cookie con "document.cookie"
   if ($resultado) {
       $idCliente = $resultado['id'];

       echo("<script>
        document.cookie = 'idCliente=$idCliente; path=/';
        </script>");
   }

   // Botón de carrito
   echo ('<div class="d-flex justify-content-end p-3">
   <a href="carrito.php" class="btn btn-primary">
       <i class="bi bi-cart"></i> Ir al Carrito
   </a>
    </div>');

   // Para mostrar la tabla de productos
   echo ('<div class="container mt-4">
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Categoría</th>
                <th>Nombre</th>
                <th>PrecioSinIVA</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>');
    // Hacemos un "foreach" para recorrer el resultado de "arrayDulces"   
    foreach ($arrayDulces as $dulce) {
        echo ('<tr>
                <td>' . htmlspecialchars($dulce['categoria']) . '</td>
                <td>' . htmlspecialchars($dulce['nombre']) . '</td>
                <td>' . number_format($dulce['precio'], 2) . ' €</td>
                <td>' . htmlspecialchars($dulce['descripcion']) . '</td>
                <td>
                    <button class="btn btn-success" onclick="agregarAlCarrito(\'' . htmlspecialchars($dulce['nombre']) . '\')">
                        Añadir al carrito
                    </button>
                </td>
            </tr>');
    }

    echo ('    </tbody>
    </table>
    </div>');

    // Obtener los pedidos del cliente
    $cliente = new Cliente($username, "", "", ""); // Creamos una instancia de Cliente
    $pedidos = $cliente->getPedidos($idCliente); // Llamamos a la función getPedidos

    // Si el cliente tiene pedidos hacemos una tabla con los articulos que ha pedido
    if (!empty($pedidos)) {
        echo ('<div class="container mt-4">
        <h3>Mis Pedidos</h3>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>PrecioConIVA</th>
                    <th>Subtotal</th>
                    <th>Fecha del Pedido</th>
                </tr>
            </thead>
            <tbody>');
        foreach ($pedidos as $pedido) {
            echo ('<tr>
                    <td>' . htmlspecialchars($pedido['nombreProducto']) . '</td>
                    <td>' . htmlspecialchars($pedido['cantidad']) . '</td>
                    <td>' . htmlspecialchars($pedido['precioUnitario']) . '</td>
                    <td>' . htmlspecialchars($pedido['subtotal']) . '</td>
                    <td>' . htmlspecialchars($pedido['fechaPedido']) . '</td>
                </tr>');
        }
        echo ('</tbody>
        </table>
        </div>');
    }




    echo("<h2 class='text-center'><button class='btn btn-danger' onclick='cerrarSesion()'>Cerrar sesión</button></h2>");

    // Incluimos el archivo para el pie de página de el "HTML"
    require_once("index2.php");
?>


<script>
    // Hacemos esta función para usarla para el botón de cerrar sesión
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

    // Hacemos esta función para sacar el valor de una cookie
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

    // Hacemos esta función para agregar un artículo al carrito
    function agregarAlCarrito(producto) {
        // Obtenemos el valor actual de la cookie para el producto específico, usamos el más para convertir el string a número
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