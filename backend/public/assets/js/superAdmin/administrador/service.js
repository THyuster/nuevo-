const URL_PETICION_MODULOS = `${constante.HOST}/admin_main`

const camposExcluir = [];
const orden = ["Grupo empresarial", "name", "email", "estado"];

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});


const buttonsModal = {
    "idCreateModal": "#createMainAdmin",
    "idEditModal": "#editMainAdmin",
    "idDeleteModal": "#deleteMainAdmin"
};
const btnModalActions = {
    "create": "#btnCreateMainAdmin",
    "edit": "#btnEditMainAdmin",
    "delete": "#btnDeleteMainAdmin"
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
        rellenarFormulario(data, "formEditMainAdmin");
        setLocalStorageId(data);
    });

    $(tbody).on("click", "#delete", function () {
        const data = getRowData(this);
        setLocalStorageId(data);
    });

    $(tbody).on("click", "#estado", function () {
        const data = getRowData(this);
        setLocalStorageId(data);
        changeStatusOrAdmin($(this), 'updateStatus');
    });
    $(tbody).on("click", "#btnadministrador", function () {
        const data = getRowData(this);
        setLocalStorageId(data);
        changeStatusOrAdmin($(this), 'statusAdmin');
    });

}

$(btnModalActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);

    let idFormulario = "formCreateMainAdmin";
    let formulario = $(`#${idFormulario}`)[0];
    let formData = new FormData(formulario);

    console.log(Object.fromEntries(formData))
    $.ajax({
        url: `${URL_PETICION_MODULOS}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log({ response });
            return handleResponse(response, button, buttonsModal.idCreateModal, idFormulario);
        },
        error: function (error) {
            console.log({ error });

            resetModal(null)
            showNotification("error", error.responseJSON.message);
            button.prop("disabled", false);
        },
    });
})


$(btnModalActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this)
    button.prop('disabled', true);
    let id = localStorage.getItem('id')
    $.ajax({
        url: `${URL_PETICION_MODULOS}/delete/${id}`,
        method: 'DELETE',
        success: function (response) {
            return handleResponse(response, button, buttonsModal.idDeleteModal, null);
        },
        error: function (error) {
            console.error(error);
            button.prop('disabled', false);
        }
    })
})

// Función para editar un registro
$(btnModalActions.edit).on("click", function (e) {

    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let idFormulario = "formEditMainAdmin"
    let formulario = $(`#${idFormulario}`)[0];
    let formData = Object.fromEntries(new FormData(formulario))

    let id = localStorage.getItem("id");


    const data = Object.entries(formData).reduce((acc, [key, value]) => {
        if (value) {
            acc[key] = value;
        }
        return acc;
    }, {});

    $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: "POST",
        data,
        success: function (response) {
            console.log({ response });
            return handleResponse(response, button, buttonsModal.idEditModal, idFormulario);
        },
        error: function (error) {
            console.log({ error });

            button.prop("disabled", false);
            showNotification("error", error.responseJSON.message);
        },
    });
})


const changeStatusOrAdmin = (button, endPoint) => {
    let id = localStorage.getItem("id");

    button.prop("disabled", true);
    console.log(`${URL_PETICION_MODULOS}/${endPoint}/${id}`);
    $.ajax({
        url: `${URL_PETICION_MODULOS}/${endPoint}/${id}`,
        method: "PUT",
        success: function (response) {
            // (response, button, modal, formulario)
            return handleResponse(response, button, null, null);
        },
        error: function (error) {
            showNotification("error");
            button.prop("disabled", false);
        },
    });
}



const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#compactData", camposExcluir);
        localStorage.removeItem("id");
        return;
    }
    cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#compactData", camposExcluir);
    localStorage.removeItem("id");
    return;
}

const rellenarFormulario = (data, formulario) => {
    for (let objeto in data) {
        if (data.hasOwnProperty(objeto)) {

            let valor = data[objeto];

            if ($(`#${formulario} input[name="${objeto}"]`).length && $(`#${formulario} input[name="${objeto}"]`).attr('type') !== 'file') {
                $(`#${formulario} input[name="${objeto}"]`).val(valor);
            }

            if ($(`#${formulario} select[name="${objeto}"]`).length) {
                $(`#${formulario} select[name="${objeto}"]`).val(valor);
            }

            if ($(`#${formulario} textarea[name="${objeto}"]`).length) {
                $(`#${formulario} textarea[name="${objeto}"]`).val(valor);
            }
        };
    };
}

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