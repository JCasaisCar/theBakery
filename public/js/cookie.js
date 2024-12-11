"use strict";
function getCookie(name) {
    // Hacemos un array de cookies con el separador "; " con ".split("; ")"
    let cookies = document.cookie.split("; ");


    // Recorremos todas las cookies con el "for of" para que nos devuelva el contenido de cada una en cada posición de el array
    for(let cookie of cookies) {
        // Hacemos un array de el nombre y el valor de cada cookie separado por el "=" con ".split("=")"
        let cookieArray = cookie.split("=");
        let cookieName = cookieArray[0];
        let cookieValue = cookieArray[1];


        if(cookieName === name) {
            // Si existe la cookie devolvemos su valor
            return cookieValue;
        } 
    }

    // Si no existe la cookie devolvemos null
    return null;
}