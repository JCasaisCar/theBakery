"use strict";

// Función para crear una tabla dinámica a partir del array de datos
function crearTabla(data) {
    // Creamos la tabla
    const tabla = document.createElement('table');
    tabla.classList.add('table', 'table-striped', 'table-bordered');

    // Creamos el encabezado de la tabla
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');

    // Creamos las cabeceras a partir de las claves del primer objeto del array
    Object.keys(data[0]).forEach(key => {
        const th = document.createElement('th');
        th.innerText = key.charAt(0).toUpperCase() + key.slice(1); // Capitalizamos la primera letra
        headerRow.appendChild(th);
    });

    thead.appendChild(headerRow);
    tabla.appendChild(thead);

    // Creamos el cuerpo de la tabla
    const tbody = document.createElement('tbody');

    // Creamos una fila para cada elemento del array
    data.forEach(item => {
        const row = document.createElement('tr');

        // Creamos una celda para cada valor del objeto
        Object.values(item).forEach(value => {
            const td = document.createElement('td');
            td.innerText = value;
            row.appendChild(td);
        });

        tbody.appendChild(row);
    });

    tabla.appendChild(tbody);

    // Insertamos la tabla en el DOM (en el contenedor con id 'tabla')
    document.getElementById('tabla').appendChild(tabla);
}


// Llamamos a la función para crear la tabla al cargar la página
crearTabla(productos);