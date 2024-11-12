URL_PETICION_MODULOS = `${constante.HOST}/modulo_configuracion/modulosUsuario`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const createAsignation = async (jsonData) => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}`,
        method: "POST",
        data: { jsonData },
        success: async function (res) {
            if (res == true) {
                resetModal("#createPermisos", "#formPermisosCrear");
                showNotification("success");
                $(".table").load(location.href + " .table");

                return;
            }
            resetModal("#createPermisos", "#formPermisosCrear");
            showNotification("error");
            $(".table").load(location.href + " .table");

            return;
        },
        error: async function (err) {
            console.error(err);
            return;
        },
    });
};

const updateAsignation = async (id, jsonData) => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/${id}`,
        method: "PUT",
        data: { jsonData },
        success: async function (res) {
            console.log("entrando a función ");
            $(".table").load(location.href + " .table");
            $("#editPermisos").modal("hide");
            $("#addPermisosForm")[0].reset();
            showNotification("updated");

            return;
        },
        error: async function (err) {
            refrescarTable();
            $("#editPermisos").modal("hide");
            $("#addPermisosForm")[0].reset();
            assignmentFailed(err.responseJSON.message);
            $(".table").load(location.href + " .table");


            return;
        },
    });
};

const deleteAsignation = async (id) => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/${id}/delete`,
        method: "DELETE",
        success: async function (res) {
            $("#deletePermission").modal("hide");  
            $(".table").load(location.href + " .table");
            showNotification("deleted");  
            refreshTable.ajax.reload();
            return;
        },
        error: async function (err) {
            

            showNotification("error");
            $(".table").load(location.href + " .table");
            return console.log(err);
        },
    });
};

function resetModal(etiquetaPermiso, etiquetaForm) {
    $(etiquetaPermiso).modal("hide");
    $(etiquetaForm)[0].reset();
    // (" .table").load(location.href + " .table");
     return;
}


