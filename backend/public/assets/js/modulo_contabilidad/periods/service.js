const camposExcluir = ['id', 'created_at', 'updated_at', 'Afiscal'];
const orden = ['año fiscal', 'codigo', 'fecha inicio', 'fecha final'];

const URL_PETICION_MODULOS = `${constante.HOST}/modulo_contabilidad/periodos`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const buttonsModal = {
    "idCreateModal": "#createPeriod",
    "idEditModal": "#editPeriod",
    "idDeleteModal": "#deletePeriod"
};

const btnModalButtonsActions = {
    "create": "#btnCreatePeriod",
    "delete": "#btnDeletePeriod",
    "edit": "#btnEditPeriod",
    "cloneYear": "#btnCloneFiscalYear",
    "filtroPeriodo": "#filtroPeriodo",
};

const obtenerDataTable = function (tbody, table) {
    $(tbody).on("click", "#edit", function () {
        let data = table.row($(this).parents("tr")).data();
        for (let objeto in data) {
            if (data.hasOwnProperty(objeto)) {
                let valor = data[objeto];
                if ($(`#formularioActualizar input[name="${objeto}"]`).length !== "file") {
                    $(`#formularioActualizar input[name="${objeto}"]`).val(valor);
                }
                if ($(`#formularioActualizar select[name="${objeto}"]`).length) {
                    $(`#formularioActualizar select[name="${objeto}"]`).val(valor);
                }
                if ($(`#formularioActualizar textarea[name="${objeto}"]`).length) {
                    $(`#formularioActualizar textarea[name="${objeto}"]`).val(valor);
                }
            }
        }
        localStorage.setItem("id", data.id);
    });


    $(tbody).on("click", "#delete", function () {
        let data = table.row($(this).parents("tr")).data();
        console.log({ data });
        localStorage.setItem("id", data.id);
    });
    $(tbody).on("click", "#estado", function (e) {
        e.preventDefault();
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id)
        changeStatus($(this), 'updateStatus');
    })
}

// Servicio de crear
$(btnModalButtonsActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let formulario = $("#formularioCrear")[0];
    let formData = new FormData(formulario);
    formData.forEach((valor, clave) => {
        console.log(clave, valor);
    });
    $.ajax({
        url: URL_PETICION_MODULOS,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            showNotification("success");
            $("#formularioCrear")[0].reset();
            resetModal(buttonsModal.idCreateModal);
        },
        error: function (err) {
            console.log(err);
            showNotification("error", err.responseJSON.message);
        },
    });
    button.prop("disabled", false);
});

//servicio de eliminar
$(btnModalButtonsActions.delete).on("click", function (e) {
    console.log('eliminar');
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let id = localStorage.getItem("id");
    console.log(`${URL_PETICION_MODULOS}/delete/${id}`);
    console.log({ id });
    $.ajax({
        url: `${URL_PETICION_MODULOS}/delete/${id}`,
        method: "DELETE",
        success: function (res) {
            console.log({ res });
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
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let id = localStorage.getItem("id");
    const dataForm = $("#formularioActualizar")[0];
    const data = new FormData(dataForm);

    $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: "POST",
        data,
        processData: false,
        contentType: false,
        success: function (res) {
            button.prop("disabled", true);
            resetModal("#editPeriod");
            showNotification("success");
        },
        error: function (err) {
            button.prop("disabled", true);
            console.log({ err });
            showNotification("error", err.responseJSON.message);
        },
    });
});

$(btnModalButtonsActions.cloneYear).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    console.log(button);
    let formulario = $("#cloneYear")[0];
    let formData = new FormData(formulario);
    formData.forEach((clave, valor) => {
        console.log(clave, valor)
    })
    $.ajax({
        url: `${URL_PETICION_MODULOS}/repeatYear`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log({ res });
            resetModal("#cloneFiscalYear");
            showNotification("success");
            button.prop("disabled", true);
        },
        error: function (err) {
            console.log(err);
            showNotification("error");
        },
    });
});
// resetModal("#cloneFiscalYear");
// button.prop("disabled", true);

function changeStatus(e) {
    const id = localStorage.getItem("id");
    e.prop("disabled", true);
    $.ajax({
        url: `${URL_PETICION_MODULOS}/updateStatus/${id}`,
        method: 'PUT',
        success: function (res) {
            console.log({ res });
            resetModal(null);
            e.prop("disabled", true);
            return;
        },
        error: function (err) {
            console.log(err);
            showNotification("error");
        },

    })

}

$("#afiscal_id").on("change", function (e) {
    e.preventDefault();
    let formulario = $("#periodFilter")[0];
    const valorForm = Object.fromEntries(new FormData(formulario));
    const idFilter = Object.values(valorForm)[0];
    const url = idFilter == 0
        ? `${URL_PETICION_MODULOS}/show`
        : `${URL_PETICION_MODULOS}/filterPeriodsByYear/${idFilter}`;
    cargarDatos(url, buttonsModal, "#compactData", camposExcluir);
})

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#compactData", camposExcluir);
        return;
    }
    cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#compactData", camposExcluir);
    return;
}

