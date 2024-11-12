const URL_PETICION_MODULOS = `/modulo_mantenimiento/solicitudes`;

const camposExcluir = ["nombres_solicitante", "apellidos_solicitante" ];
const orden = ["numero_solicitud", "centro_trabajo_descripcion", "tipo_solicitud_descripcion", "equipo_descripcion", "matricula_vehiculo", "prioridad_descripcion", "tercero_descripcion", "movil_solicitante", "email_solicitante", "fecha_solicitud", "fecha_cierre", "ruta_imagen", "observacion"];

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const buttonsModal = {
    "idEditModal": "#updateRequest",
    "idDeleteModal": "#deleteRequest",
    "idCreateModal": "#createRequest",
};
const btnModalActions = {
    "edit": "#btnUpdateRequest",
    "delete": "#btnDeleteRequest",
    "create": "#btnCreateRequest",
};

const obtenerDataTable = function (tbody, table) {
    const getRowData = (element) => {
        let rowNode = table.row($(element)).node();
        let data = table.row(rowNode).data();
        console.log(data);
        return data;
    };

    const setLocalStorageId = (data) => localStorage.setItem("id", data.id);

    $(tbody).on("click", "#edit", async function () {
        const data = getRowData(this);
        rellenarFormulario(data, "formUpdateRequest");
        setLocalStorageId(data);
        $("#formUpdateRequest img[id='imagen_solicitud']").attr('src', data.ruta_imagen);
    });

    $(tbody).on("click", "#delete", function () {
        const data = getRowData(this);
        setLocalStorageId(data);
    });
};


$("#formUpdateRequest input[name='ruta_imagen']").change(function (event) { pushimagen(event, "formUpdateRequest") });


const pushimagen = (event, formulario) => {
    let archivo = event.target.files[0];
    let lector = new FileReader();
    lector.onload = function (e) {
        $(`#${formulario} img[id='imagen_solicitud']`).attr('src', e.target.result).show();
    };
    lector.readAsDataURL(archivo);
}


//Solicitud de crear
$(btnModalActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let formulario = $("#formCreateRequest")[0];
    let formData = new FormData(formulario);
    $.ajax({
        url: URL_PETICION_MODULOS,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            // console.log(res);
            showNotification("success");
            $("#formCreateRequest")[0].reset();
            resetModal(buttonsModal.idCreateModal);
        },
        error: function (err) {
            console.log(err);
            showNotification("error", err.responseJSON.message);
        },
    });
    button.prop("disabled", false);
});

//Solicitud editar
$(btnModalActions.edit).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disable", true);
    let formulario = $("#formUpdateRequest")[0];
    const valorForm = Object.fromEntries(new FormData(formulario));
    let id = localStorage.getItem("id");
    // let valorForm = new FormData(formulario);
    $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: "POST",
        data: valorForm,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log(res);
            showNotification("success");
            resetModal(buttonsModal.idEditModal);
        },
        error: function (err) {
            console.log(err);
            showNotification("error", err.responseJSON.message);
        },
    });
    button.prop("disabled", false);
});

//servicio de eliminar
$(btnModalActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let id = localStorage.getItem("id");

    $.ajax({
        url: `${URL_PETICION_MODULOS}/delete/${id}`,
        method: "DELETE",
        success: function (res) {
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

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
    }
    cargarDatos(
        `${URL_PETICION_MODULOS}/show`,
        buttonsModal,
        "#compactData",
        camposExcluir
    );
    return;
};

const rellenarFormulario = (data, formulario) => {
    for (let objeto in data) {
        if (data.hasOwnProperty(objeto)) {
            let valor = data[objeto];

            if (
                $(`#${formulario} input[name="${objeto}"]`).length &&
                $(`#${formulario} input[name="${objeto}"]`).attr("type") !==
                "file"
            ) {
                $(`#${formulario} input[name="${objeto}"]`).val(valor);
            }

            if ($(`#${formulario} textarea[name="${objeto}"]`).length) {
                $(`#${formulario} textarea[name="${objeto}"]`).val(valor);
            }

            if (
                $(`#${formulario} input[type="checkbox"][name="${objeto}"]`)
                    .length &&
                valor == 1
            ) {
                $(`#${formulario} input[type="checkbox"][name="${objeto}"]`).prop(
                    "checked",
                    true
                );
            }

            if ($(`#${formulario} select[name="${objeto}"]`).length) {
                $(`#${formulario} select[name="${objeto}"]`).val(valor);
            }
        }
    }
};
