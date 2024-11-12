const URL_PETICION_MODULOS = `/modulo_mantenimiento/tipos_solicitudes`;

const camposExcluir = [];
const orden = [];

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const buttonsModal = {
    "idEditModal": "#updateTypeRequest",
    "idDeleteModal": "#deleteTypeRequest",
    "idCreateModal": "#createTypeRequest"
};
const btnModalActions = {
    "edit": "#btnUpdateTypeRequest",
    "delete": "#btnDeleteTypeRequest",
    "create": "#btncreateTypeRequest"
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
        rellenarFormulario(data,"formUpdateTypeRequest");
        setLocalStorageId(data);
    });

    $(tbody).on("click", "#delete", function () {
        const data = getRowData(this);
        setLocalStorageId(data);
    });

    
}

//Solicitud de crear 
$(btnModalActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let formulario = $("#formCreateTypeRequest")[0];
    let formData = new FormData(formulario);
    $.ajax({
        url: URL_PETICION_MODULOS,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            showNotification("success");
            $("#formCreateTypeRequest")[0].reset();
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
    let formulario = $("#formUpdateTypeRequest")[0];
    const valorForm = Object.fromEntries(new FormData(formulario));
    let id = localStorage.getItem("id");

    $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: "PUT",
        data: valorForm,
        success: function (res) {
            showNotification("success");
            resetModal("#updateTypeRequest");

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
    cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#compactData", camposExcluir);
    return;
}

const rellenarFormulario = (data) =>{
    
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
}