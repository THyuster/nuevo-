import { completador, mostrarSugerencias } from "./Completador.js";

let sugerencias = await completador("/logistica/vehiculos/entidades");

let timeoutId;

$(document).ready(function () {

    const input_propietario = $('#formularion_creacion input[id="propietario_id"]');

    const input_conductor = $('#formularion_creacion input[id="conductor_id"]');

    const input_conductor_actualizar = $('#updateSpecs input[id="conductor_id"]');

    const input_propietario_actualizar = $('#updateSpecs input[id="propietario_id"]');

    const formulario_actualizar = "#updateSpecs"

    const formulario = "#formularion_creacion";

    const campos_propietario = ["apellidos_propietario", "nombres_propietario", "movil_propietario", "email_propietario"];

    const campos_conductor = ["apellidos_conductor", "nombres_conductor", "movil_conductor", "email_conductor"];

    input_propietario.on('keydown keyup', function (e) {
        if (e.key === 'Backspace' || e.key === 'Delete') {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_propietario, sugerencias, true, formulario, campos_propietario), 1000);
        } else {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_propietario, sugerencias, false, formulario, campos_propietario), 1000);
        }
    });

    input_conductor.on('keydown keyup', function (e) {
        if (e.key === 'Backspace' || e.key === 'Delete') {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_conductor, sugerencias, true, formulario, campos_conductor), 1000);
        } else {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_conductor, sugerencias, false, formulario, campos_conductor), 1000);
        }
    });

    input_propietario_actualizar.on('keydown keyup', function (e) {
        if (e.key === 'Backspace' || e.key === 'Delete') {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_propietario_actualizar, sugerencias, true, formulario_actualizar, campos_propietario), 1000);
        } else {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_propietario_actualizar, sugerencias, false, formulario_actualizar, campos_propietario), 1000);
        }
    });

    input_conductor_actualizar.on('keydown keyup', function (e) {
        if (e.key === 'Backspace' || e.key === 'Delete') {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_conductor_actualizar, sugerencias, true, formulario_actualizar, campos_conductor), 1000);
        } else {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_conductor_actualizar, sugerencias, false, formulario_actualizar, campos_conductor), 1000);
        }
    });

});
