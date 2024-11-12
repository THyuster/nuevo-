const url = location.href + "/show"

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const camposExcluir = ['id', 'sucursal_id'];


const buttonsModal = {
    "idEditModal": "#editGrupoContable",
    "idDeleteModal": "#deleteGrupoContable",
    "idCreateModal": "#createGrupoContable"
};

const btnModalActions = {
    "edit": "#btnEditGrupoContable",
    "delete": "#btnDeleteGrupoContable",
    "create": "#btnCreateGrupoContable"
};


const obtenerDataTable = function (tbody, table) {
    $(tbody).on("click", "#edit", function () {
        let data = table.row($(this).parents("tr")).data();
        $("#floatingDescripcionUpdate").val(data.descripcion);
        $("#floatingCodigoUpdate").val(data.codigo);
        // $("#idSucursalUpdate").val(data.sucursal_id);
        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#delete", function () {
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
    });
}

$(btnModalActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this)
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
$(btnModalActions.edit).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop('disabled', true);
    let data = {
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

$(btnModalActions.create).on("click", function (e) {
    console.log("hola");
    e.preventDefault();
    let button = $(this);
    button.prop('disabled', true);
    let data = {
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