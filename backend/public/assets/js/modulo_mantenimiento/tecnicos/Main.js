import { completador, mostrarSugerencias } from "../../components/Completador.js";

let sugerencias = await completador("/modulo_mantenimiento/tecnicos/terceros");

let timeoutId;

$(document).ready(function () {

    const input_tecnicos = $('#formCreateTechnician input[id="tercero_id"]'); //CREAR

    const input_tecnicos_actualizar = $('#formUpdateTechnician input[id="tercero_id"]'); //ACTUALIZAR

    const formulario_actualizar = "#formUpdateTechnician" //FORM ACTUALIZAR

    const formulario = "#formCreateTechnician"; //FORM CREAR

    const campos_tecnicos = ["apellidos_tecnicos", "nombres_tecnicos"];

    // rellenar datos con tercero_id
    input_tecnicos.on('keydown keyup', function (e) {
        if (e.key === 'Backspace' || e.key === 'Delete') {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_tecnicos, sugerencias, true, formulario, campos_tecnicos), 1000);
        } else {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_tecnicos, sugerencias, false, formulario, campos_tecnicos), 1000);
        }
    });

    // console.log(input_tecnicos);
    // Rellenar campos en edición
    input_tecnicos_actualizar.on('keydown keyup', function (e) {
        if (e.key === 'Backspace' || e.key === 'Delete') {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_tecnicos_actualizar, sugerencias, true, formulario_actualizar, campos_tecnicos), 1000);
        } else {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(mostrarSugerencias(input_tecnicos_actualizar, sugerencias, false, formulario_actualizar, campos_tecnicos), 1000);
        }
    });
});
