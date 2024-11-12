const idioma_espanol = {
    // Información traducida a español para datatables localmente
    "decimal": "",
    "emptyTable": "No existe información en esta tabla",
    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
    "infoEmpty": "Mostrando 0 to 0 de 0 entradas",
    "infoFiltered": "(filtrado desde _MAX_ entradas totales)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Mostrar _MENU_ entradas",
    "loadingRecords": "Cargando...",
    "processing": "",
    "search": "Buscar:",
    "zeroRecords": "No se encontraron datos de busqueda",
    "paginate": {
        "first": "Primero",
        "last": "Ultimo",
        "next": "Siguiente",
        "previous": "Anterior"
    },
    "aria": {
        "sortAscending": ": activa para organizar en orden ascendente",
        "sortDescending": ": activa para organizar en orden descendente"

    },
}

const lengthMenu = [
    [10, 25, 50, -1],
    [10, 25, 50, "Todos"]
];

const columnDefs = [
    {
        // "targets": "_all", // Última columna (acciones)
        // "className": 'dt-head-center' //centrar titulos
    }
];

const modificarColumnas = ["estado", "signo", "ruta_imagen", "entidad_administrador", "administrador", "propio", "modificado", "ejemplo"];

const patron = /(_id|_at|_nombres|_apellidos|_password|id|Id)$/i;

const columnasTransformacion = (key, data) => {

    switch (key) {
        case "estado":
            let buttonTemplate;
            // return data;
            // console.log(data);
            if (data == "No SuAdmin") {
                buttonTemplate = data
            } else if (data === 1 || data === "ACTIVO") {
                buttonTemplate = '<button type="submit" class="btn btn-success" id="estado">Activo</button>';
            } else {
                buttonTemplate = '<button type="submit" class="btn btn-warning" id="estado">Inactivo</button>';
            }
            return buttonTemplate;
        case "modificado":
            return (data === 1) ? 'Sí' : 'No';
        case "propio":
            return (data === 1) ? 'Sí' : 'No';
        case "ruta_imagen":
            return `<img src="${data}" class="img-thumbnail" alt="imagen_articulo" width="200px">`;
        case "administrador":
            return (data === "SI") ? '<button type="submit" class="btn btn-success" id="btnadministrador">SI</button>'
                : '<button type="submit" class="btn btn-warning" id="btnadministrador">NO</button>';
        case "ejemplo":
            return `<h1>HOLA</h1>`;
        case "signo":
            return (data === 1) ? '<button type="submit" class="btn btn-success" id="signo">1</button>'
                : '<button type="submit" class="btn btn-warning" id="signo">-1</button>';
        default:
            break;
    }
}