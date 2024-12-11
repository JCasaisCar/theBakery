<?php
    namespace theBakery\public\testing;

    use theBakery\public\src\Cliente;
    use theBakery\public\src\Bollo;
    use theBakery\public\src\Tarta;
    use theBakery\public\src\Pasteleria;

    // Incluimos los archivos necesarios
    require_once("../src/Cliente.php");
    require_once("../src/Bollo.php");
    require_once("../src/Tarta.php");
    require_once("../src/Pasteleria.php");

    // Creamos algunos dulces
    $bollo1 = new Bollo("Bollo de crema", 1.50, "Un delicioso bollo relleno de crema pastelera", "Bollería", "Crema");
    $bollo2 = new Bollo("Bollo de chocolate", 1.80, "Bollo con relleno de chocolate", "Bollería", "Chocolate");

    $tarta1 = new Tarta(
        "Tarta de cumpleaños", 
        20.00, 
        "Tarta de chocolate con fondant", 
        "Pasteles", 
        ["Chocolate", "Vainilla"], 
        2, 
        4, 
        8
    );

    $tarta2 = new Tarta(
        "Tarta de bodas", 
        50.00, 
        "Tarta de bodas de varios pisos", 
        "Pasteles", 
        ["Fresa", "Nata", "Chocolate"], 
        3, 
        10, 
        20
    );

    // Creamos algunos clientes
    $cliente1 = new Cliente("Juan Pérez", "juanp", "1234", "juan@juan.com");
    $cliente2 = new Cliente("Ana López", "anal", "5678", "ana@ana.com");

    // Creamos la pastelería
    $pasteleria = new Pasteleria();

    // Incluimos los productos en la pastelería
    $pasteleria->incluirDulce($bollo1);
    $pasteleria->incluirDulce($bollo2);
    $pasteleria->incluirDulce($tarta1);
    $pasteleria->incluirDulce($tarta2);

    // Incluimos los clientes en la pastelería
    $pasteleria->incluirCliente($cliente1);
    $pasteleria->incluirCliente($cliente2);

    // Listamos productos y clientes de la pastelería
    echo "<h3>Productos disponibles:</h3>";
    $pasteleria->listarProductos();

    echo "<h3>Clientes registrados:</h3>";
    $pasteleria->listarClientes();

    // Juan compra un dulce
    echo "<h3>Acciones del cliente Juan:</h3>";
    $cliente1->comprar($bollo1);
    $cliente1->comprar($tarta1);

    // Juan intenta comprar el mismo dulce otra vez
    $cliente1->comprar($bollo1);

    // Juan valora un dulce
    $cliente1->valorar($bollo1, "Delicioso bollo, muy fresco.");

    // Ana compra y valora
    echo "<h3>Acciones del cliente Ana:</h3>";
    $cliente2->comprar($tarta2);
    $cliente2->valorar($tarta2, "Perfecta para la ocasión especial.");

    // Listamos pedidos realizados por Juan
    echo "<h3>Pedidos realizados por Juan:</h3>";
    $cliente1->listarPedidos();

    // Listamos pedidos realizados por Ana
    echo "<h3>Pedidos realizados por Ana:</h3>";
    $cliente2->listarPedidos();
?>