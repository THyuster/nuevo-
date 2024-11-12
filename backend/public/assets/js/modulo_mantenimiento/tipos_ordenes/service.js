const URL_PETICION_MODULOS = `/modulo_mantenimiento/tipos_ordenes`;

const camposExcluir = [];
const orden = [];

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const buttonsModal = {
    "idEditModal": "#updateTypeOrder",
    "idDeleteModal": "#deleteTypeOrder",
    "idCreateModal": "#createTypeOrder"
};
const btnModalActions = {
    "edit": "#btnUpdateTypeOrder",
    "delete": "#btnDeleteTypeOrder",
    "create": "#btnCreateTypeOrder"
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
        // let rowNode = table.row($(element)).node();
        // let data = table.row(rowNode).data();
        // return data;
    };

    const setLocalStorageId = (data) => localStorage.setItem("id", data.id);

    $(tbody).on("click", "#edit", function () {
        const data = getRowData(this);
        rellenarFormulario(data,buttonsModal.idEditModal);
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
        console.log("funcionó");
    });
}

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
    let formulario = $("#formCreateTypeOrder")[0];
    let formData = new FormData(formulario);   
    $.ajax({
        url: URL_PETICION_MODULOS,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            showNotification("success");
            $("#formCreateTypeOrder")[0].reset();
            console.log("funciona");
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
    let formulario = $("#formUpdateTypeOrder")[0];
    const valorForm = Object.fromEntries(new FormData(formulario));
    let id = localStorage.getItem("id");

    $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: "POST",
        data: valorForm,
        success: function (res) {
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
    cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#compactData", camposExcluir);
    return;
}

const rellenarFormulario = (data) =>{
    
    for (let objeto in data) {
        if (data.hasOwnProperty(objeto)) {

            let valor = data[objeto];

            if ($(`#updateTypeOrder input[name="${objeto}"]`).length && $(`#updateTypeOrder input[name="${objeto}"]`).attr('type') !== 'file') {
                $(`#updateTypeOrder input[name="${objeto}"]`).val(valor);
            }

            if ($(`#updateTypeOrder textarea[name="${objeto}"]`).length) {
                $(`#updateTypeOrder textarea[name="${objeto}"]`).val(valor);
            }

            if ($(`#updateTypeOrder input[type="checkbox"][name="${objeto}"]`).length && valor == 1) {
                $(`#updateTypeOrder input[type="checkbox"][name="${objeto}"]`).prop("checked", true);
            }

            if ($(`#updateTypeOrder select[name="${objeto}"]`).length) {
                $(`#updateTypeOrder select[name="${objeto}"]`).val(valor);
            }

        };
    };
}