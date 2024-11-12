const camposExcluir = ["id", "created_at", "updated_at", "razon_social"];
const orden = ["nit", "Empresa"];

const URL_PETICION_MODULOS = `${constante.HOST}/modulo_contabilidad/empresas`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const buttonsModal = {
    idEditModal: "#editCompany",
    idDeleteModal: "#deleteCompany",
    idCreateModal: "#createCompany",
};

const btnModalButtonsActions = {
    create: "#btnCreateCompany",
    delete: "#btnDeleteCompany",
    edit: "#btnEditCompany",
};

const obtenerDataTable = function (tbody, table) {
    $(tbody).on("click", "#edit", function () {
        let data = table.row($(this).parents("tr")).data();
        for (let objeto in data) {
            if (data.hasOwnProperty(objeto)) {
                let valor = data[objeto];

                if (
                    $(`#formularioActualizar input[name="${objeto}"]`)
                        .length !== "file"
                ) {
                    $(`#formularioActualizar input[name="${objeto}"]`).val(
                        valor
                    );
                }

                if (
                    $(`#formularioActualizar select[name="${objeto}"]`).length
                ) {
                    $(`#formularioActualizar select[name="${objeto}"]`).val(
                        valor
                    );
                }

                if (
                    $(`#formularioActualizar textarea[name="${objeto}"]`).length
                ) {
                    $(`#formularioActualizar textarea[name="${objeto}"]`).val(
                        valor
                    );
                }
            }
        }
        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#delete", function () {
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
    });
    $(tbody).on("click", "#estado", function (e) {
        e.preventDefault();
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
        changeStatus($(this), "updateStatus");
    });
};

//servicio de eliminar
$(btnModalButtonsActions.delete).on("click", function (e) {
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

// Servicio de editar
$(btnModalButtonsActions.edit).on("click", function (e) {
    console.log("das11");
    e.preventDefault();
    let button = $(this);

    let id = localStorage.getItem("id");
    button.prop("disabled", true);

    let formulario = $("#formularioActualizar")[0];
    validateForm(formulario);

    const data = new FormData(formulario);
    $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: "POST",
        data,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log({ res });
            button.prop("disabled", false);
            resetModal("#editCompany");
            showNotification("success");
        },
        error: function (err) {
            button.prop("disabled", false);
            console.log({ err });
            showNotification("error", err.responseJSON.message);
        },
    });
});

// Servicio de crear
$("#btnCreateCompany").on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    // button.prop("disabled", true);
    let formulario = $("#formularioCrear")[0];

    // if (!(formulario.checkValidity())) {
    //     const elementosConErrores = formulario.querySelectorAll(':invalid');
    //     elementosConErrores.forEach((element) => $(element).after('<p>' + element.validationMessage + '</p>'))
    // }
    validateForm(formulario);
    const data = new FormData(formulario);
    $.ajax({
        url: URL_PETICION_MODULOS,
        method: "POST",
        data,
        processData: false,
        contentType: false,
        success: function (res) {
            showNotification("success");
            $("#formularioCrear")[0].reset();
            button.prop("disabled", false);
            resetModal(buttonsModal.idCreateModal);
        },
        error: function (err) {
            button.prop("disabled", false);
            console.log(err);
            showNotification("error", err.responseJSON.message);
        },
    });
});
function validateForm(formulario) {
    if (!formulario.checkValidity()) {
        const elementosConErrores = formulario.querySelectorAll(":invalid");
        elementosConErrores.forEach((element) =>
            $(element).after("<p>" + element.validationMessage + "</p>")
        );
    }
}
function changeStatus(e) {
    const id = localStorage.getItem("id");
    e.prop("disabled", true);
    $.ajax({
        url: `${URL_PETICION_MODULOS}/updateStatus/${id}`,
        method: "PUT",
        success: function (res) {
            resetModal(null);
            e.prop("disabled", true);
            return;
        },
        error: function (err) {
            console.log(err);
            showNotification("error");
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
