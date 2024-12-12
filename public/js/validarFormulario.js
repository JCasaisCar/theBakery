"use strict";

function validarFormulario(form) {
    let isValid = true;
    let errorMessage = '';

    // Iteramos sobre los campos específicos del formulario
    for (let element of form.elements) {
        if (element.name === 'name' || element.name === 'username' || element.name === 'mail' || element.name === 'password') {
            // Validamos que el campo no esté vacío
            if (!element.value.trim()) {
                isValid = false;
                errorMessage = `El campo ${element.placeholder} es obligatorio.`;
                break;
            }

            // Validamos que el correo electrónico sea correcto
            if (element.name === 'mail' && !/\S+@\S+\.\S+/.test(element.value)) {
                isValid = false;
                errorMessage = 'Por favor, ingrese un correo electrónico válido.';
                break;
            }

            // Validamos que la contraseña sea correcta (al menos 5 caracteres)
            if (element.name === 'password' && element.value.length < 5) {
                isValid = false;
                errorMessage = 'La contraseña debe tener al menos 6 caracteres.';
                break;
            }
        }
    }

    // Mostramos mensaje de error si la validación falla
    if (!isValid) {
        alert(errorMessage);
    }

    return isValid;
}
