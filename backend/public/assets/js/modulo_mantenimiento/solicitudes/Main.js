import { completador, mostrarSugerencias } from "../../components/Completador.js";

let sugerencias = await completador("/modulo_mantenimiento/solicitudes/terceros");

let timeoutId;

$(document).ready(function () {

    const input_solicitante = $('#formCreateRequest input[id="tercero_id"]'); //CREAR

    const input_solicitante_actualizar = $('#formUpdateRequest input[id="tercero_id"]'); //ACTUALIZAR

    const formulario_actualizar = "#formUpdateRequest" //FORM ACTUALIZAR

    const formulario = "#formCreateRequest"; //FORM CREAR

    const campos_propietario = ["apellidos_solicitante", "nombres_solicitante", "movil_solicitante", "email_solicitante"];

    input_solicitante.on('keydown keyup', function (e) {
        if (e.key === 'Backspace' || e.key === 'Delete') {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_solicitante, sugerencias, true, formulario, campos_propietario), 1000);
        } else {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_solicitante, sugerencias, false, formulario, campos_propietario), 1000);
        }
    });

    // console.log(input_solicitante);

    input_solicitante_actualizar.on('keydown keyup', function (e) {
        if (e.key === 'Backspace' || e.key === 'Delete') {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_solicitante_actualizar, sugerencias, true, formulario_actualizar, campos_propietario), 1000);
        } else {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_solicitante_actualizar, sugerencias, false, formulario_actualizar, campos_propietario), 1000);
        }
    });
});
