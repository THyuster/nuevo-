const url = location.href + "/show"

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const camposExcluir = ['id', 'sucursal_id'];


const buttonsModal = {
    "idEditModal": "#editStore",
    "idDeleteModal": "#deleteStore",
    "idCreateModal": "#createStore"
};

const buttonModalActions = {
    "edit": "#btnEditStore",
    "delete": "#btnDeleteStore",
    "create": "#btnCreateStore"
};

const obtenerDataTable = function (tbody, table) {
    $(tbody).on("click", "#edit", function () {
        let rowNode = table.row($(this).closest("tr")).node();
        let data = table.row(rowNode).data();
        $("#floatingDescripcionUpdate").val(data.descripcion);
        $("#floatingCodigoUpdate").val(data.codigo);
        $("#idSucursalUpdate").val(data.sucursal_id);
        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#delete", function () {
        let rowNode = table.row($(this).closest("tr")).node();
        let data = table.row(rowNode).data();
        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#estado", function (e) {
        let rowNode = table.row($(this).closest("tr")).node();
        let data = table.row(rowNode).data();
        localStorage.setItem("id", data.id);
        changeEstado($(this));
    });
}

$(buttonModalActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop('disabled', true);
    let id = localStorage.getItem('id')
    $.ajax({
        url: location.href + `/delete/${id}`,
        method: 'DELETE',
        success: function (response) {
            if (response == "elimino") {
                resetModal(buttonsModal.idDeleteModal);
                button.prop('disabled', false);
                localStorage.clear();
                showNotification("deleted");
                return;
            }
            resetModal(buttonsModal.idDeleteModal);
            button.prop('disabled', false);
            localStorage.clear();
            showNotification("error", response);
            return;
        },
        error: function () {
        }
    })
})

// Función para editar un registro
$(buttonModalActions.edit).on("click", function (e) {
    e.preventDefault();
    let button = $(this);

    button.prop('disabled', true);
    let data = {
        "sucursal_id": $("#idSucursalUpdate :selected").val(),
        "codigo": $("#floatingCodigoUpdate").val(),
        "descripcion": $("#floatingDescripcionUpdate").val()
    }
    let id = localStorage.getItem('id')
    $.ajax({
        url: location.href + `/update/${id}`,
        method: 'PUT',
        data: data,
        success: function (response) {
            if (response == "Actualizo") {
                resetModal(buttonsModal.idEditModal);
                button.prop('disabled', false);
                localStorage.clear();
                showNotification("updated");
                return;
            }
            resetModal(buttonsModal.idEditModal);
            button.prop('disabled', false);
            localStorage.clear();
            showNotification("error", response);
            return;
        },
        error: function () {
        }
    })
})

function changeEstado(e) {
    let id = localStorage.getItem("id");
    e.prop('disabled', true);
    $.ajax({
        url: location.href + `/estado/${id}`,
        method: 'PUT',
        success: function (response) {
            showNotification("loading");
            resetModal(null);
            e.prop('disabled', true);
            localStorage.clear();
            showNotification("success");
            return;
        },
        error: function () {
            showNotification("erro");
        }
    })
}

$(buttonModalActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);

    button.prop('disabled', true);
    let data = {
        "sucursal_id": $("#idSucursal :selected").val(),
        "codigo": $("#floatingCodigo").val(),
        "descripcion": $("#floatingDescripcion").val(),
    };
    $.ajax({
        url: location.href,
        method: 'POST',
        data: data,
        success: function (response) {
            if (response == "Creo") {
                resetModal(buttonsModal.idCreateModal);
                button.prop('disabled', false);
                localStorage.clear();
                showNotification("success");
                $("#formPermisosCrear")[0].reset();
                return;
            }
            resetModal(buttonsModal.idCreateModal);
            button.prop('disabled', false);
            localStorage.clear();
            showNotification("error", response);
            return;

        },
        error: function () {
        }
    })
})

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(url, buttonsModal, "#tabla", camposExcluir);
        return;
    }
    cargarDatos(url, buttonsModal, "#tabla", camposExcluir);
    return;
}