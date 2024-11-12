const camposExcluir = ['id','created_at','updated_at', 'afiscal'];
const orden = [];

const URL_PETICION_MODULOS = `${constante.HOST}/modulo_contabilidad/afiscal`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const buttonsModal = {
    "idCreateModal": "#createFiscalYear",
    "idEditModal": "#editFiscalYear",
    "idDeleteModal": "#deleteFiscalYear"
};

const btnModalButtonsActions = {
    "create": "#btnCreateFiscalYear",
    "delete": "#btndDeleteFiscalYear",
    "edit": "#btnEditFiscalYear",
};

const obtenerDataTable = function (tbody, table) {
    $(tbody).on("click", "#edit", function () {
        let data = table.row($(this).parents("tr")).data();
        for (let objeto in data) {
            if (data.hasOwnProperty(objeto)) {
                let valor = data[objeto];

                if ( $(`#formularioActualizar input[name="${objeto}"]`).length !== "file") {
                    $(`#formularioActualizar input[name="${objeto}"]`).val(valor);
                }

                if ($(`#formularioActualizar select[name="${objeto}"]`).length) {
                    $(`#formularioActualizar select[name="${objeto}"]`).val(valor);
                }

                if (  $(`#formularioActualizar textarea[name="${objeto}"]`).length) {
                    $(`#formularioActualizar textarea[name="${objeto}"]`).val(valor);
                }
            }
        }
        localStorage.setItem("id", data.id);
    });
    $(tbody).on("click", "#delete", function () {
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
    });
    $(tbody).on("click", "#estado", function (e){
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

    if (formulario.checkValidity()) {
    } else {
        $("#mensaje_error").html("<p>error</p>")
        button.prop("disabled", false);  
    }
    let formData = new FormData(formulario);
    formData.forEach((valor, clave) => {
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
            button.prop("disabled", false);

        },
        error: function (err) {

            resetModal(buttonsModal.idCreateModal);
            showNotification("error", err.responseJSON.message);
            button.prop("disabled", false);

        },
    });
    
});

//servicio de eliminar
$(btnModalButtonsActions.delete).on("click", function (e) {
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
            button.prop("disabled", false);

        },
        error: function (err) {
            resetModal(buttonsModal.idDeleteModal);
            showNotification("error", err.responseJSON.message);
            button.prop("disabled", false);

        },
    });
    
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
            resetModal("#editFiscalYear");
            button.prop("disabled", false);

            showNotification("success");
        },
        error: function (err) {
            resetModal("#editFiscalYear");
            showNotification("error", res.responseJSON.message);
            button.prop("disabled", false);

        },
    });
});



function changeStatus(e){
    const id = localStorage.getItem("id");
    e.prop("disabled", true);
    $.ajax({
        url:`${URL_PETICION_MODULOS}/updateStatus/${id}`,
        method:'PUT',
        success:function(res){
            resetModal(null);
            e.prop("disabled", true);
            return;
        },
        error: function (err) {
            showNotification("error");
        },

    })

}

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(`${URL_PETICION_MODULOS}/show`,buttonsModal, "#compactData", camposExcluir);
        return;
    }
    cargarDatos(`${URL_PETICION_MODULOS}/show`,buttonsModal, "#compactData", camposExcluir);
    return;
}

