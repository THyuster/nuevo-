const url = location.href + "/show";

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const camposExcluir = ['id'];


const buttonsModal = {
    idEditModal: "#actualizarTrailer",
    idDeleteModal: "#eliminarTrailer",
    idCreateModal: "#crearTrailer",
};

const buttonModalActions = {
    edit: "#btnActualizarTrailer",
    delete: "#btnEliminarTrailer",
    create: "#btnCrearTrailer",
};

const obtenerDataTable = function (tbody, table) {

    $(tbody).on("click", "#edit", function () {

        let rowNode = table.row($(this).closest("tr")).node();
        let data = table.row(rowNode).data();

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
        let rowNode = table.row($(this).closest("tr")).node();
        let data = table.row(rowNode).data();
        localStorage.setItem("id", data.id);
    });

};

$(buttonModalActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let id = localStorage.getItem("id");
    $.ajax({
        url: location.href + `/${id}`,
        method: "DELETE",
        success: function (response) {
            if (response == "elimino") {
                resetModal(buttonsModal.idDeleteModal);
                button.prop("disabled", false);
                localStorage.clear();
                showNotification("deleted");
                return;
            }
            resetModal(buttonsModal.idDeleteModal);
            button.prop("disabled", false);
            localStorage.clear();
            showNotification("error", response);
            return;
        },
        error: function () { },
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
        url: location.href + `/${id}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            if (response == "Actualizo") {
                resetModal(buttonsModal.idEditModal);
                // button.prop("disabled", false);
                button.prop("disabled", false);
                localStorage.clear();
                showNotification("updated");
                return;
            }
            resetModal(buttonsModal.idEditModal);
            localStorage.clear();
            showNotification("error", response);
            return;
        },
        error: function (error) {
            console.log(error);
            button.prop("disabled", false);

        },
    });
});


$(buttonModalActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);

    let formulario = $("#formularioCrear")[0];
    let formData = new FormData(formulario);

    $.ajax({
        url: location.href,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response == "Creo") {
                resetModal(buttonsModal.idCreateModal);
                localStorage.clear();
                button.prop("disabled", false);
                showNotification("success");
                $("#formularioCrear")[0].reset();
                return;
            }
            resetModal(buttonsModal.idCreateModal);
            button.prop('disabled', false);
            localStorage.clear();
            showNotification("error", response);
            return;
        },
        error: function (error) {
            console.log(error);
            button.prop("disabled", false);
        },
    });
});

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(url, buttonsModal, "#tabla",camposExcluir);
        return;
    }
    cargarDatos(url, buttonsModal, "#tabla",camposExcluir);
    return;
};

