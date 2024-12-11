"use strict";

// Función para crear una tabla dinámica a partir del array de datos
function crearTabla(data) {
    // Crear la tabla
    const tabla = document.createElement('table');
    tabla.classList.add('table', 'table-striped', 'table-bordered');

    // Crear el encabezado de la tabla
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');

    // Crear las cabeceras a partir de las claves del primer objeto del array
    Object.keys(data[0]).forEach(key => {
        const th = document.createElement('th');
        th.innerText = key.charAt(0).toUpperCase() + key.slice(1); // Capitaliza la primera letra
        headerRow.appendChild(th);
    });

    thead.appendChild(headerRow);
    tabla.appendChild(thead);

    // Crear el cuerpo de la tabla
    const tbody = document.createElement('tbody');

    // Crear una fila para cada elemento del array
    data.forEach(item => {
        const row = document.createElement('tr');

        // Crear una celda para cada valor del objeto
        Object.values(item).forEach(value => {
            const td = document.createElement('td');
            td.innerText = value;
            row.appendChild(td);
        });

        tbody.appendChild(row);
    });

    tabla.appendChild(tbody);

    // Insertar la tabla en el DOM (en el contenedor con id 'tabla')
    document.getElementById('tabla').appendChild(tabla);
}


    // Llamar a la función para crear la tabla al cargar la página
crearTabla(productos);
