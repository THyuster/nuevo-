
const url = "/su_administrador/crear/superadmin"

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const camposExcluir = [];

const buttonsModal = {
    "idEditModal": "#editSuperSU",
    "idDeleteModal": "#deleteSuperSU",
    "idCreateModal": "#createSuperSU"
};
const btnModalActions = {
    "edit": "#btnEditSuperSU",
    "delete": "#btnDeleteSuperSU",
    "create": "#btnAsignarSu"
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
        rellenarFormulario(data, "formActualizarSuperSU");
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

}


$(btnModalActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this)
    button.prop('disabled', true);
    let id = localStorage.getItem('id')


    $.ajax({
        url: `/su_administrador/crear/superadmin/${id}`,
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
    let idFormulario = "formActualizarSuperSU"
    let formulario = $(`#${idFormulario}`)[0];
    let formData = new FormData(formulario);

    let id = localStorage.getItem("id");

    $.ajax({
        url: `/superAdmin/crear/superAdministrador/${id}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            return handleResponse(response, button, buttonsModal.idEditModal, idFormulario);
        },
        error: function (error) {
            button.prop("disabled", false);
            showNotification("error", error.responseJSON.message);
        },
    });
})


const changeEstado = (button) => {
    let id = localStorage.getItem("id");

    button.prop("disabled", true);

    $.ajax({
        url: `/superAdmin/superAdministrador/${id}`,
        method: "PUT",
        success: function (response) {
            return handleResponse(response, button, null, null);
        },
        error: function (error) {
            showNotification("error");
            button.prop("disabled", false);
        },
    });
}

$(btnModalActions.create).on("click", async function (e) {
    e.preventDefault();

    let formulario = "form_su_admin";
    let button = $(this);

    formulario = $(`#${formulario}`)[0];

    let formData = new FormData(formulario);

    $.ajax({
        url: "/su_administrador/crear/superadmin",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            // return console.log(response);
            return handleResponse(response, button, buttonsModal.idCreateModal, formulario);
        },
        error: function (error) {
        //    return console.log(error);
            resetModal(null)
            showNotification("error", error.responseJSON.message);
            button.prop("disabled", false);
        },
    });
})

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos("/su_administrador/crear/superadmin/show", buttonsModal, "#tabla", camposExcluir);
        localStorage.removeItem("id");
        return;
    }
    cargarDatos("/su_administrador/crear/superadmin/show", buttonsModal, "#tabla", camposExcluir);
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

// $(document).