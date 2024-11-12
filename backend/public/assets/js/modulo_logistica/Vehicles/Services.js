const url = "/logistica/vehiculos/show";
let urlImagenDefault = 'http://181.48.57.46:8083/imagenes/Sgju118SpEmmjMjy0n6pHmhKhmnNaWpPQoUHw2oGio4In60Le5F82SGDioQ2dHyKN6JUp1tIPyRz1jYYNZLJQlEDeSYOU2JZe21ysZu3JHSDESmY17dNyfYI.png'

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
const camposIncluir = [];
// console.log(camposIncluir.length);

const camposExcluir = [
    "id",
    "created_at",
    "updated_at",
    "operacion",
    "conductor_id",
    "apellidos_conductor",
    "nombres_conductor",
    "movil_conductor",
    "email_conductor",
    "apellidos_propietario",
    "nombres_propietario",
    "email_propietario",
    "movil_propietario",
    "nombre_conductor",
    "propietario_id",
    "nombre_propietario",
    "vehiculo_marca_id",
    "nombre_marca",
    "vehiculo_modelo",
    "vehiculo_linea",
    "vehiculo_color",
    "vehiculo_serial_motor",
    "vehiculo_serial_chasis",
    "gps_empresa",
    "gps_usuario",
    "gps_id",
    "gps_password",
    "gps_numero",
    "vehiculo_clase_id",
    "nombre_clase",
    "tipo_contrato_id",
    "ejes_id",
    "nombre_ejes",
    "combustible_id",
    "nombre_combustible",
    "blindaje_id",
    "nombre_blindaje",
    "soat_valor",
    "gases_valor",
    "seguro_valor",
    "cilindraje",
    "tara",
    "pasajeros",
    "km_ini",
    "contrato",
    "trailer_modelo"
]

const orden = ["matricula", "vehiculo_placa", "tipo_trailer", "grupo_vehiculo", "afiliacion", "desvinculacion",
    "propio", "modificado", "soat_empresa", "soat_ini", "soat_fin", "gases_empresa", "gases_ini", "gases_fin", "seguro_empresa",
    "seguro_ini", "seguro_fin", "ruta_imagen", "observacion", "estado"];


const buttonsModal = {
    idEditModal: "#vehiclesUpdate",
    idDeleteModal: "#DeleteVehicle",
    idCreateModal: "#vehiclesCreate",
};

const buttonModalActions = {
    edit: "#btnUpdateVehicle",
    delete: "#btnDeleteVehicle",
    create: "#btnSaveVehicle",
};

const obtenerDataTable = (tbody, table) => {

    $(tbody).on("click", "#edit", function () {

        let rowNode = table.row(this).node();
        let data = table.row(rowNode).data();

        $("#updateSpecs img[id='imagen_vehiculo']").attr('src', data.ruta_imagen);

        for (let objeto in data) {
            if (data.hasOwnProperty(objeto)) {

                let valor = data[objeto];

                if ($(`#updateSpecs input[name="${objeto}"]`).length && $(`#updateSpecs input[name="${objeto}"]`).attr('type') !== 'file') {
                    $(`#updateSpecs input[name="${objeto}"]`).val(valor);
                }

                if ($(`#updateSpecs textarea[name="${objeto}"]`).length) {
                    $(`#updateSpecs textarea[name="${objeto}"]`).val(valor);
                }

                if ($(`#updateSpecs input[type="checkbox"][name="${objeto}"]`).length && valor == 1) {
                    $(`#updateSpecs input[type="checkbox"][name="${objeto}"]`).prop("checked", true);
                }

                if ($(`#updateSpecs select[name="${objeto}"]`).length) {
                    $(`#updateSpecs select[name="${objeto}"]`).val(valor);
                }

            };
        };

        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#delete", function () {

        let rowNode = table.row(this).node();
        let data = table.row(rowNode).data();
        localStorage.setItem("id", data.id);

    });

    $(tbody).on("click", "#estado", function (e) {
        let rowNode = table.row(this).node();
        let data = table.row(rowNode).data();
        localStorage.setItem("id", data.id);
        changeEstado($(this));
    });

};

const changeEstado = (button) => {
    let id = localStorage.getItem("id");
    button.prop("disabled", false);
    $.ajax({
        url: `/logistica/vehiculos/${id}`,
        method: "PUT",
        success: function (response) {
            showNotification("loading");
            resetModal(null);
            button.prop("disabled", true);
            showNotification("success");
            return;
        },
        error: function (error) {
            console.log(error.responseJSON.message);
            showNotification("error", error.responseJSON.message);
            button.prop("disabled", true);
        },
    });
}

$(buttonModalActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let id = localStorage.getItem("id");
    $.ajax({
        url: `/logistica/vehiculos/${id}`,
        method: "DELETE",
        success: function (response) {
            if (response.mensaje == "Elimino") {
                resetModal(buttonsModal.idDeleteModal);
                button.prop("disabled", false);
                localStorage.removeItem("id");
                showNotification("deleted");
                return;
            }
            resetModal(buttonsModal.idDeleteModal);
            button.prop("disabled", false);
            localStorage.removeItem("id");
            showNotification("error", response.mensaje);
            return;
        },
        error: function (error) {
            console.log(error.responseJSON.message);
            showNotification("error", error.responseJSON.message);
            button.prop("disabled", false);
        },
    });
});

// Función para editar un registro
$(buttonModalActions.edit).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);

    let formulario = $("#updateSpecs")[0];
    let formData = new FormData(formulario);

    $('#updateSpecs input[type="checkbox"]:checked').each(function () {
        formData.append($(this).attr('id'), 1);
    });

    $('#updateSpecs input[type="checkbox"]').not(':checked').each(function () {
        formData.append($(this).attr('id'), 0);
    });

    let id = localStorage.getItem("id");

    $.ajax({
        url: `/logistica/vehiculos/${id}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);

            if (response.mensaje == "Actualizo") {
                resetModal(buttonsModal.idEditModal);
                button.prop("disabled", false);
                showNotification("updated");
                return;
            }

            resetModal(buttonsModal.idEditModal);
            button.prop("disabled", false);

            showNotification("error", response.mensaje);
            return;
        },
        error: function (error) {
            console.log(error.responseJSON.message);
            showNotification("error", error.responseJSON.message);
            button.prop("disabled", false);
        },
    });
});


$(buttonModalActions.create).on("click", function (e) {
    e.preventDefault();

    let button = $(this);
    button.prop("disabled", true);

    let formulario = $("#formularion_creacion")[0];
    let formData = new FormData(formulario);

    $('#formularion_creacion input[type="checkbox"]:checked').each(function () {
        formData.append($(this).attr('id'), 1);
    });

    $('#updateSpecs input[type="checkbox"]').not(':checked').each(function () {
        formData.append($(this).attr('id'), 0);
    });

    $.ajax({
        url: '/logistica/vehiculos',
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.mensaje == "Creo") {
                resetModal(buttonsModal.idCreateModal);
                button.prop("disabled", false);
                showNotification("success");
                $("#formularion_creacion")[0].reset();
                $("#formularion_creacion img[id='imagenPrevisualizacion']").attr('src', urlImagenDefault);
                return;
            }
            resetModal(buttonsModal.idCreateModal);
            button.prop('disabled', false);
            showNotification("error", response.mensaje);
            return;
        },
        error: function (error) {
            console.log(error.responseJSON.message);
            showNotification("error", error.responseJSON.message);
            button.prop("disabled", false);
        },
    });
});

$("#updateSpecs input[name='ruta_imagen']").change(function (event) { pushimagen(event, "updateSpecs") });

$("#formularion_creacion input[name='ruta_imagen']").change(function (event) { pushimagen(event, "formularion_creacion") });

const pushimagen = (event, formulario) => {
    let archivo = event.target.files[0];
    let lector = new FileReader();
    lector.onload = function (e) {
        $(`#${formulario} img[id='imagen_vehiculo']`).attr('src', e.target.result).show();
    };
    lector.readAsDataURL(archivo);
}

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(url, buttonsModal, "#tabla", camposExcluir, orden, camposIncluir);
        localStorage.removeItem("id");
        return;
    }
    cargarDatos(url, buttonsModal, "#tabla", camposExcluir, orden, camposIncluir);
    localStorage.removeItem("id");
    return;
};