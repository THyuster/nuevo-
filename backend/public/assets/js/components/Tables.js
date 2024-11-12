$(document).ready(function () {
    refrescarTable();
});

const refrescarTable = function () {
    tablaDatos = $('#compactData').DataTable({
        "language": idioma_espanol,
        //Patrón de separación para busqueda de datos
        "lengthMenu": lengthMenu,
        //velocidad de busqueda
        "searchDelay": 500,
        //Alineación de titulos de la tabla al centro, objetivo (todos)
        "columnDefs": columnDefs,

        "stateSave": true
    });
    return;

}

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
        targets: "_all",
        className: 'dt-head-center'
    }
];
