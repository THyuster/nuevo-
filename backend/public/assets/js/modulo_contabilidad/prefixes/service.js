const URL_PETICION_MODULOS = `${constante.HOST}/contabilidad/prefijos`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const camposExcluir = [];
const orden = [];


const buttonsModal = {
    idEditModal: "#editPrefix",
    idDeleteModal: "#deletePrefix",
    idCreateModal: "#createPrefix",
};

const buttonModalActions = {
    edit: "#btnEditPrefix",
    delete: "#btnDeletePrefix",
    create: "#btnCreatePrefix",
};

const obtenerDataTable = function (tbody, table) {

    $(tbody).on("click", "#edit", function () {
        // let rowNode = table.row(this).node();
        let data = table.row($(this).parents("tr")).data();

        for (let objeto in data) {
            if (data.hasOwnProperty(objeto)) {
                let valor = data[objeto];
                if ($(`#formularioActualizar input[name="${objeto}"]`).length) {
                    $(`#formularioActualizar input[name="${objeto}"]`).val(valor);
                }
            };
        };

        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#delete", function () {
        let data = table.row($(this).parents("tr")).data();
         
        localStorage.setItem("id", data.id);

    });

    $(tbody).on("click", "#estado", function (e) {
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
        changeEstado($(this));
    });

};

function changeEstado(e) {
    
    let id = localStorage.getItem("id");
    e.prop("disabled", true);
    $.ajax({
        url: `${URL_PETICION_MODULOS}/${id}/updateStatus`,
        method: "PUT",
        success: function (response) {
            console.log({response});
            resetModal(null);
            e.prop("disabled", true);
            return;
        },
        error: function (error) {
            console.log(error);
            showNotification("erro");
        },
    });
}



$(buttonModalActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);

    let formulario = $("#formularioCrear")[0];
    let formData = new FormData(formulario);

    $.ajax({
        url: `${URL_PETICION_MODULOS}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log({response});
            resetModal(buttonsModal.idCreateModal);
            button.prop("disabled", false);
            showNotification("success");
            $("#formularioCrear")[0].reset();
            return;
        },
        error: function (err) {
            console.log({err});
            resetModal(buttonsModal.idEditModal);
            button.prop("disabled", false);
            showNotification("error", err.responseJSON.message);
        },
    });
});



// Función para editar un registro
$(buttonModalActions.edit).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);

    let formulario = $("#formularioActualizar")[0];
    let formData = new FormData(formulario);

    let id = localStorage.getItem("id");
    
    $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            resetModal(buttonsModal.idEditModal);
            button.prop("disabled", false);
            showNotification("updated");
            return;
        },
        error: function (err) {
            console.log({err});
            resetModal(buttonsModal.idEditModal);
            button.prop("disabled", false);
            showNotification("error", err.responseJSON.message);
        },
    });
});


$(buttonModalActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let id = localStorage.getItem("id");
    $.ajax({
        url: `${URL_PETICION_MODULOS}/delete/${id}`,
        method: "DELETE",
        success: function (response) {
            console.log({response});
            
            resetModal(buttonsModal.idDeleteModal);
            button.prop("disabled", false);
            showNotification("success");
            $("#formularioCrear")[0].reset();
            return;

        },
        error: function (err) { 
            resetModal(buttonsModal.idDeleteModal);
            button.prop("disabled", false);
            showNotification("error", err.responseJson.message);
        },
    });
});


const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#compactData", camposExcluir);
        return;
    }
    cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#compactData", camposExcluir);
    return;
};