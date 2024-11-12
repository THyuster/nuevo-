const URL_PETICION_MODULOS = `/modulo_mantenimiento/tecnicos`;

const camposExcluir = ["observaciones", "nombres_tecnicos", "apellidos_tecnicos"];
const orden = ["identificacion", "nombre_completo", "especialidad", "fecha_inicio", "fecha_final", "estado"];

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const buttonsModal = {
    "idCreateModal": "#createTechnician",
    "idEditModal": "#updateTechnician",
    "idDeleteModal": "#deleteTechnician",
};
const btnModalActions = {
    "create": "#btnCreateTechnician",
    "edit": "#btnUpdateTechnician",
    "delete": "#btnDeleteTechnician",
};

const obtenerDataTable = function (tbody, table) {
    const getRowData = (element) => {

        if (window.innerWidth <= 353) {
            let rowNode = table.row($(element)).node();
            return table.row(rowNode).data();
        }

        if (window.innerWidth >= 353 && window.innerWidth <= 458) {

            let rowNode = table.row($(element)).node();

            if (rowNode === null) {
                rowNode = table.row($(element).parents("tr")).node();
            }
            return table.row(rowNode).data();
        }
        return table.row($(element).parents("tr")).data();
    };

    const setLocalStorageId = (data) => localStorage.setItem("id", data.id);

    $(tbody).on("click", "#edit", async function () {
        const data = getRowData(this);
        console.log(data);
        rellenarFormulario(data, "formUpdateTechnician");
        setLocalStorageId(data);
    });

    $(tbody).on("click", "#delete", function () {
        const data = getRowData(this);
        setLocalStorageId(data);
    });

    $(tbody).on("click", "#estado", function () {
        const data = getRowData(this);
        setLocalStorageId(data);
        changeEstado($(this));
    });
};

// BOTON CAMBIO ACTIVO O INACTIVO
const changeEstado = (button) => {
    let id = localStorage.getItem("id");
    button.prop("disabled", false);
    $.ajax({
        url: `${URL_PETICION_MODULOS}/updateStatus/${id}`,
        method: "PUT",
        success: function (response) {
            console.log(response);
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

//Solicitud de crear
$(btnModalActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let formulario = $("#formCreateTechnician")[0];
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
            $("#formCreateTechnician")[0].reset();
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
    let formulario = $("#formUpdateTechnician")[0];
    const valorForm = Object.fromEntries(new FormData(formulario));
    let id = localStorage.getItem("id");

    $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: "POST",
        data: valorForm,
        success: function (res) {
            // console.log(res);
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
