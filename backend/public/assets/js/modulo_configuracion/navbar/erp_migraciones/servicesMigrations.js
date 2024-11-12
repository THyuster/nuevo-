URL_PETICION_MIGRACION = `${constante.HOST}/modulo_configuracion/erp_migraciones`;
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

/*AJAX CREAR MIGRACION*/
const createMigracion = async (jsonData) => {
    console.log('creando migracion');
    await $.ajax({
        url: `${URL_PETICION_MIGRACION}`,
        method: "POST",
        data: jsonData,
        success: function (res) {
            console.log({ res });
            $("#createMigration").modal("hide");
            $("#createMigration form")[0].reset();
            $(".table").load(location.href + " " + ".table");
            showNotification("success", "Migracion Creada Exitosamente.");
            return;
        },
        error: function (err) {
            console.log({ err });
        },
    });
};

/* AJAX EDITAR MIGRACION */
const editMigracion = async (id, data) => {

    await $.ajax({
        url: `${URL_PETICION_MIGRACION}/edit/${id}`,
        method: "PUT",
        data,
        success: function (res) {
            $("#editarMigracion").modal("hide");
            $(".table").load(location.href + " " + ".table");
            showNotification("success", "Migracion Actualizada Exitosamente.");
            return;
        },
        error: function (err) {
            return err;
        },
    });
    return;
};

/* ELIMINAR REGISTRO */
const deleteMigration = async (id) => {
    await $.ajax({
        url: `${URL_PETICION_MIGRACION}/${id}/delete`,
        method: "DELETE",
        success: function (res) {
            resetModal("#deleteMigration", null, ".table");
            location.reload();
            showNotification("deleted", "Migracion Eliminada Exitosamente.");
            return;
        },
        error: function (err) {
            console.log({ err });
            return;
        },
    });
    return;
};

const changeStatusModule = async ($id) => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/status`,
        method: "PUT",
        data: { jsonDataUpdate, jsonDataWhere },
        success: function (res) {
            if (res == true) {
                resetModal("#editarModules", "#formPermisosEditar", ".table");
                $(".table").load(location.href + " .table");
                return;
            }
            return console.log(res);
        },
        error: function (err) {
            return err;
        },
    });
    return;
};

const validarDb = async () => {
    await $.ajax({
        url: `${constante.HOST}/modulo_configuracion/diseno_modulos/validationdb`,
        method: "POST",
        success: function (res) {
            return console.log(res);
        },
        error: function (err) {
            return console.log(err);
        },
    });
    return;
};

function resetModal(etiquetaPermiso, etiquetaForm, table) {
    $(etiquetaPermiso).modal("hide");
    //$(etiquetaForm)[0].reset();
    $(table).load(location.href + " " + table);

    return;
}
