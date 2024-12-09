<?php
    use theBakery\Bollo;
    use theBakery\Tarta;
    use theBakery\Chocolate;

    // Incluimos los archivos necesarios
    require_once("../src/Bollo.php");
    require_once("../src/Tarta.php");
    require_once("../src/Chocolate.php");
    

    // Bollo
    echo("<h1>Prueba bollo: </h1> <br>");
    $bollo = new Bollo("Croissant", 1.20, "Bollo relleno de chocolate", "Bollos", "Chocolate");
    $bollo->createDulce(); // Prueba el método para crear

    // Probamos el método "readAll"
    $resultado = $bollo->readAllDulce();
    echo "<pre>";
    print_r($resultado);
    echo "</pre>";

    // Probamos el método "read"
    $idDulce = 1;
    $resultado = $bollo->readDulce($idDulce);
    echo "<pre>";
    print_r($resultado);
    echo "</pre>";

    // Probamos el método "update"
    $bollo->setNombre("Croissant Actualizado"); // Cambia atributos con un método `set`
    $bollo->updateDulce($idDulce);

    // Probamos el método "delete"
    $bollo->deleteDulce($idDulce);


    // Chocolate
    echo("<h1>Prueba chocolate: </h1> <br>");
    $chocolate = new Chocolate("Barra de Chocolate", 2.50, "Chocolate con leche y almendras", "Chocolates", 10, 20);
    $chocolate->createDulce(); // Prueba el método para crear

    // Probamos el método "readAll"
    $resultado = $chocolate->readAllDulce();
    echo "<pre>";
    print_r($resultado);
    echo "</pre>";

    // Probamos el método "read"
    $idDulce = 2;
    $resultado = $chocolate->readDulce($idDulce);
    echo "<pre>";
    print_r($resultado);
    echo "</pre>";

    // Probamos el método "update"
    $chocolate->setNombre("Chocolate con Almendras Actualizado"); // Cambia atributos con un método `set`
    $chocolate->updateDulce($idDulce);

    // Probamos el método "delete"
    $chocolate->deleteDulce($idDulce);


    // Tarta
    echo("<h1>Prueba tarta: </h1> <br>");
    $tarta = new Tarta("Tarta de Queso", 15.00, "Deliciosa tarta de queso al horno", "Tartas", ["chocolate", "galleta"], 2, 4, 20);
    $tarta->createDulce(); // Prueba el método para crear

    // Probamos el método "readAll"
    $resultado = $tarta->readAllDulce();
    echo "<pre>";
    print_r($resultado);
    echo "</pre>";

    // Probamos el método "read"
    $idDulce = 3;
    $resultado = $tarta->readDulce($idDulce);
    echo "<pre>";
    print_r($resultado);
    echo "</pre>";

    // Probamos el método "update"
    $tarta->setNombre("Tarta de Queso Actualizada"); // Cambia atributos con un método `set`
    $tarta->updateDulce($idDulce);

    // Probamos el método "delete"
    $tarta->deleteDulce($idDulce);


    // Bollo
    echo("<h1>Prueba bollo: </h1> <br>");
    $bollo = new Bollo("Croissant", 1.20, "Bollo relleno de chocolate", "Bollos", "Chocolate");
    $bollo->createDulce(); // Prueba el método para crear

    // Probamos el método "readAll"
    $resultado = $bollo->readAllDulce();
    echo "<pre>";
    print_r($resultado);
    echo "</pre>";

    // Probamos el método "read"
    $idDulce = 4;
    $resultado = $bollo->readDulce($idDulce);
    echo "<pre>";
    print_r($resultado);
    echo "</pre>";

    // Probamos el método "update"
    $bollo->setNombre("Croissant Actualizado"); // Cambia atributos con un método `set`
    $bollo->updateDulce($idDulce);

    // Probamos el método "delete"
    $bollo->deleteDulce($idDulce);
?>