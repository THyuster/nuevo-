const URL_PETICION_MODULOS = `${constante.HOST}/su_admin/grupo_empresarial`;

const camposExcluir = [];
const orden = [
    "codigo",
    "descripcion",
    "nombre_completo",
    "Cant Emp",
    "cant usuarios",
];

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const buttonsModal = {
    idEditModal: "#editClient",
    idCreateModal: "#createClient",
    idDeleteModal: "#deleteClient",
};
const btnModalActions = {
    create: "#btnCreateClient",
    edit: "#btnEditClient",
    delete: "#btnDeleteClient",
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

    $(tbody).on("click", "#edit", function () {
        const data = getRowData(this);
        rellenarFormulario(data, "formActualizarGrupoEmpresarial");
        setLocalStorageId(data);
        for (let objeto in data) {
            if (data.hasOwnProperty(objeto)) {
                let valor = data[objeto];

                if ($(`#formEditClient input[name="${objeto}"]`).length) {
                    $(`#formEditClient input[name="${objeto}"]`).val(valor);
                }

                if ($(`#formEditClient select[name="${objeto}"]`).length) {
                    $(`#formEditClient select[name="${objeto}"]`).val(valor);
                }
            }
        }
        localStorage.setItem("id", data.id);
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

$(btnModalActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);

    let formulario = $(`#formCreateClient`)[0];
    let formData = new FormData(formulario);
    console.log(Object.fromEntries(formData));
    console.log({ URL_PETICION_MODULOS });
    $.ajax({
        url: `${URL_PETICION_MODULOS}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log({ res });
            showNotification("success");
            $("#formCreatelicense")[0].reset();
            resetModal(buttonsModal.idCreateModal);
            button.prop("disabled", false);
        },
        error: function (err) {
            console.log(err);
            button.prop("disabled", false);
            showNotification("error");
            showNotification("error", err.responseJSON.message);
        },
    });
});

$(btnModalActions.delete).on("click", function (e) {
    e.preventDefault();

    console.log("hola");
    let button = $(this);
    button.prop("disabled", true);
    let id = localStorage.getItem("id");
    $.ajax({
        url: `${URL_PETICION_MODULOS}/delete/${id}`,
        method: "DELETE",
        success: function (response) {
            console.log({ response });
            showNotification("success");
            resetModal(buttonsModal.idDeleteModal);
            button.prop("disabled", false);
        },
        error: function (error) {
            console.error(error);
            button.prop("disabled", false);
            showNotification("error", error.responseJSON.message);
        },
    });
});

// Función para editar un registro
$(btnModalActions.edit).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let formulario = $(`#formEditClient`)[0];
    let formData = new FormData(formulario);

    let id = localStorage.getItem("id");
    $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log({ response });
            showNotification("success");
            resetModal(buttonsModal.idEditModal);
            button.prop("disabled", false);
        },
        error: function (error) {
            console.log({ error });
            button.prop("disabled", false);
            showNotification("error", error.responseJSON.message);
        },
    });
});

const changeEstado = (button) => {
    let id = localStorage.getItem("id");

    button.prop("disabled", true);

    $.ajax({
        url: `${URL_PETICION_MODULOS}/updateStatus/${id}`,
        method: "PUT",
        success: function (response) {
            console.log({ response });
            showNotification("success");
            resetModal((modal = null));
            button.prop("disabled", false);
        },
        error: function (error) {
            resetModal((modal = null));
            console.log({ error });
            showNotification("error");
            button.prop("disabled", false);
        },
    });
};

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(
            `${URL_PETICION_MODULOS}/show`,
            buttonsModal,
            "#compactData",
            camposExcluir
        );
        localStorage.removeItem("id");
        return;
    }
    cargarDatos(
        `${URL_PETICION_MODULOS}/show`,
        buttonsModal,
        "#compactData",
        camposExcluir
    );
    localStorage.removeItem("id");
    return;
};

const rellenarFormulario = (data, formulario) => {
    for (let objeto in data) {
        if (data.hasOwnProperty(objeto)) {
            let valor = data[objeto];
            if ($(`#${formulario} select[name="${objeto}"]`).length) {
                $(`#${formulario} select[name="${objeto}"]`).val(valor);
            }
        }
    }
};

const handleResponse = (response, button, modal, formulario) => {
    resetModal(modal);
    button.prop("disabled", false);
    if (response !== null && formulario !== null) {
        showNotification("success");
        $(`#${formulario}`)[0].reset();
    }

    if (formulario == null) {
        showNotification("success");
    }
};
