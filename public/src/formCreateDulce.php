<?php
    // Configuramos el namespace
    namespace theBakery\public\src;

    // Usamos la variable "$title" para asignar el título de la página a "Crear Dulce"
    $title = "Crear Dulce";

    // Incluimos el archivo para la cabecera de el "HTML"
    require_once("../index1.php");

    // Mostramos el formulario de creación
    echo ("<h3 class='mb-4'>Crear Nuevo Dulce</h3>");
    echo ("<form action='insertDulce.php' method='POST'>
            <div class='mb-3'>
                <label for='nombre' class='form-label'>Nombre</label>
                <input type='text' class='form-control' id='nombre' name='nombre' required>
            </div>
            <div class='mb-3'>
                <label for='precio' class='form-label'>Precio</label>
                <input type='number' class='form-control' id='precio' name='precio' required>
            </div>
            <div class='mb-3'>
                <label for='descripcion' class='form-label'>Descripción</label>
                <input type='text' class='form-control' id='descripcion' name='descripcion' required>
            </div>
            <div class='mb-3'>
                <label for='categoria' class='form-label'>Categoría</label>
                <select class='form-select' id='categoria' name='categoria' required>
                    <option value='' disabled selected>Seleccione una categoría</option>
                    <option value='Bollos'>Bollos</option>
                    <option value='Chocolates'>Chocolates</option>
                    <option value='Tartas'>Tartas</option>
                </select>
            </div>
            <button type='submit' class='btn btn-success'>Crear Dulce</button>
        </form>");

    // Incluimos el archivo para el pie de página
    require_once("../index2.php");
?>
