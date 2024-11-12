

const camposExcluir = [
    "id",
    "created_at",
    "fecha_actualizacion",
    "fecha_creacion",
    "fecha_inactivo",
    "nombre1",
    "Nombre1",
    "nombre2",
    "apellido1",
    "apellido2",
    "grupo_sanguineo",
    "naturaleza_juridica",
    "fecha_nacimiento",
    "municipioId",
    "idRelacionTercero",
    "IdRelacionTercero",
    "tipo_identificacion",
];

const orden = [
    "Tipo de identificacion",
    "identificacion",
    "DV",
    "Nombre completo",
    "direccion",
    "telefono_fijo",
    "movil",
    "municipio",
    "observacion",
    "email",
    "ruta_imagen"
];

const URL_PETICION_MODULOS = `${constante.HOST}/modulo_contabilidad/terceros`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const buttonsModal = {
    idCreateModal: "#thirdParty",
    idEditModal: "#thirdPartyEdit",
    idDeleteModal: "#deleteThird",
};

const btnModalButtonsActions = {
    create: "#btnConfirmThirdParty",
    edit: "#btnThirdPartyEdit",
    delete: "#btnDeleteThird",
};

const obtenerDataTable = function (tbody, table) {
    $(tbody).on("click", "#edit", function () {
        let rowNode = table.row(this).node();
        let data = table.row(rowNode).data();

        console.log({ data })
        $('#formExtenseDataUpdate input[type="checkbox"]').prop("checked", false);

        data.idRelacionTercero.forEach((value) => {
            $(`#formExtenseDataUpdate input[value="${value}"]`).prop("checked", true);
        });
        // const date = new Date().getFullYear()
        // console.log( data.fecha_actualizacion)

        // data.fecha_actualizacion=20230824;
        // console.log( data.fecha_actualizacion)
        // const fechaHora = data.fecha_actualizacion.split(' ');

        $("#formExtenseDataUpdate img[id='imagenPrevisualizacion']").attr(
            "src",
            data.ruta_imagen
        );

        for (let objeto in data) {
            if (data.hasOwnProperty(objeto)) {
                let valor = data[objeto];

                if ($(`#formExtenseDataUpdate input[name="${objeto}"]`).length && $(`#formExtenseDataUpdate input[name="${objeto}"]`).attr("type") !== "file") {
                    $(`#formExtenseDataUpdate input[name="${objeto}"]`).val(valor);
                }

                if (
                    $(`#formExtenseDataUpdate select[name="${objeto}"]`).length
                ) {
                    $(`#formExtenseDataUpdate select[name="${objeto}"]`).val(
                        valor
                    );
                }

                if (
                    $(`#formExtenseDataUpdate textarea[name="${objeto}"]`)
                        .length
                ) {
                    $(`#formExtenseDataUpdate textarea[name="${objeto}"]`).val(
                        valor
                    );
                }
            }
        }

        // $("#formExtenseDataUpdate input[name='fecha_actualizacion']").val(fechaHora[0]);


        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#delete", function () {
        let rowNode = table.row(this).node();
        let data = table.row(rowNode).data();

        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#estado", function () {
        let rowNode = table.row(this).node();
        let data = table.row(rowNode).data();
        localStorage.setItem("id", data.id);
        updateStatus($(this));
    });
};
// Servicio de crear
$("#btnConfirmThirdParty").on("click", function (e) {
    e.preventDefault();
    let button = $(this);

    button.prop("disabled", true);

    let formulario = $("#formExtenseData")[0];
    let formData = new FormData(formulario);

    $('#formExtenseData input[type="checkbox"]:checked').each(function () {
        formData.append("tipo_tercero[]", $(this).val());
    });
    const data = Object.fromEntries(formData);
    console.log({ data })
    $.ajax({
        url: URL_PETICION_MODULOS,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log({ res });
            showNotification("success");
            $("#formExtenseData")[0].reset();
            resetModal(buttonsModal.idCreateModal);
        },
        error: function (err) {
            console.log(err);
            resetModal(buttonsModal.idCreateModal);
            showNotification("error", err.responseJSON.message);
        },
    });
    button.prop("disabled", false);
});


// Servicio de editar
$(btnModalButtonsActions.edit).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);

    let id = localStorage.getItem("id");

    let formulario = $("#formExtenseDataUpdate")[0];
    let formData = new FormData(formulario);

    $('#checkedInput input[type="checkbox"]:checked').each(function () {
        formData.append("tipo_tercero[]", $(this).val());
    });
    const data = Object.fromEntries(formData);
    // console.log({ data })

    $.ajax({
        url: `${URL_PETICION_MODULOS}/${id}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log({ res });
            showNotification("success");
            button.prop("disabled", false);
            resetModal(buttonsModal.idEditModal);
            button.prop("disabled", false);

        },
        error: function (err) {
            console.log(err.responseJSON);
            button.prop("disabled", false);

            resetModal(buttonsModal.idEditModal);
            showNotification("error", err.responseJSON.message);
        },
    });
});
// Servicio de eliminar
$(btnModalButtonsActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this);

    button.prop("disabled", true);
    let id = localStorage.getItem("id");
    console.log({ id });
    $.ajax({
        url: `${URL_PETICION_MODULOS}/${id}`,
        method: "DELETE",
        success: function (res) {
            console.log({ res });
            resetModal(buttonsModal.idDeleteModal);
            showNotification("deleted");
        },
        error: function (err) {
            console.log({ err });
            resetModal(buttonsModal.idDeleteModal);
            showNotification("error", err.responseJSON.message);
        },
    });

    button.prop("disabled", false);
});

function updateStatus(e) {
    let button = e;
    button.prop("disabled", true);
    const id = localStorage.getItem("id");
    console.log("editar estatus", id);
    $.ajax({
        url: `${URL_PETICION_MODULOS}/${id}/updateStatus`,
        method: "PUT",

        success: function (res) {
            console.log({ res });
            resetModal(null);
            showNotification("success");
        },
        error: function (err) {
            console.log(err.responseJSON);
            showNotification("error", err.responseJSON.message);
            resetModal(null);
        },
    });
}

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(
            `${URL_PETICION_MODULOS}/show`,
            buttonsModal,
            "#compactData",
            camposExcluir
        );
        return;
    }
    cargarDatos(
        `${URL_PETICION_MODULOS}/show`,
        buttonsModal,
        "#compactData",
        camposExcluir
    );
    return;
};

$("#formExtenseDataUpdate input[name='ruta_imagen']").change(function (event) {
    let archivo = event.target.files[0];
    let lector = new FileReader();
    lector.onload = function (e) {
        $("#formExtenseDataUpdate img[id='imagenPrevisualizacion']")
            .attr("src", e.target.result)
            .show();
    };
    lector.readAsDataURL(archivo);
});

$("#formExtenseData input[name='ruta_imagen']").change(function (event) {
    let archivo = event.target.files[0];
    let lector = new FileReader();
    lector.onload = function (e) {
        $("#formExtenseData img[id='imagenPrevisualizacion']")
            .attr("src", e.target.result)
            .show();
    };
    lector.readAsDataURL(archivo);
});
