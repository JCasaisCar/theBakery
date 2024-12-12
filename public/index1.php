<?php namespace theBakery\public;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Definición de la codificación de caracteres -->
    <meta charset="UTF-8">
    <!-- Configuración de la vista para dispositivos móviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Css de Bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">
    
    <!-- Script de Bootstrap 5.3.3 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
            crossorigin="anonymous"></script>

    <!-- Script de Validaciones de formularios para archivos de la misma ruta -->
    <script src="js/validarFormulario.js" defer></script>

    <!-- Script de Validaciones de formularios para archivos de otra ruta -->
    <script src="../js/validarFormulario.js" defer></script>
    
    <!-- Título de la página, que es definido dinámicamente desde PHP -->
    <title><?php echo $title; ?></title>
</head>
<body>
    <div class="container-fluid justify-content-center align-items-center vh-100">