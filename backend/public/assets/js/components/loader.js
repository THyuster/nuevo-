$(document).ready(function () {
    // Selecciona el elemento de carga y la tabla
    var loading = $(".loader");
    var tableBody = $("#tabla");

    // Realiza la solicitud Ajax
    $.ajax({
        url: URL_PETICION_MODULOS,
        type: "GET",
        beforeSend: function (befor) {
            // Muestra el elemento de carga antes de la solicitud Ajax

            loading.show();
        },
        success: function (data) {
            // Oculta el elemento de carga después de que se complete la solicitud Ajax
            loading.hide();
            // Inserta los datos en la tabla
            tableBody.html(data);
        },
        error: function () {
            // Manejo de errores, puedes personalizarlo según tus necesidades
            loading.hide();
            alert("Error al cargar los datos.");
        },
    });
});
