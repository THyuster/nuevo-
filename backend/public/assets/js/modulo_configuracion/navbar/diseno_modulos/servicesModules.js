URL_PETICION_MODULOS = `/su_administrador/diseno_modulos`;
URL_PETICION_MENUS = `/su_administrador/diseno_menus`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const createModule = async (data) => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}`,
        method: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function (res) {
            resetModal("#createModules", "#formPermisosCrear");
            showNotification("success");
            $(".table").load(location.href + " .table");
            return;
        },
        error: function (err) {
            resetModal("#createModules", "#formPermisosCrear");
            showNotification("error");
            console.log(err.responseText);
            return;
        },
    });
};
//Servicio de edición de modulos
const editModule = async (data) => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/editar`,
        method: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: async function (res) {
          console.log(res);
            if (res == true) {
                resetModal("#editModules");
                showNotification("updated");
                $(".table").load(location.href + " .table");
            }
            return;
        },
        error: function (err) {
            console.log(err);
            resetModal("#editModules");
            showNotification("error");
            // return err;
        },
    });
    return;
};
//Función de borrar Módulo.
const deleteModule = async (id) => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/${id}/delete`,
        method: "DELETE",
        success: function (res) {
            showNotification("deleted");
            $("#deleteConfirmationModal").modal("hide");
            resetModal("#deleteConfirmationModal");
            $(".table").load(location.href + " .table");
            return;
        },
        error: function (err) {
            resetModal("#deleteConfirmationModal");
            showNotification("error");
            return;
        },
    });
    return;
};

const linkMenu = async (id) => {
    await $.ajax({
        url: `${URL_PETICION_MENUS}/${id}/menus`,
        method: "GET",
        data: { id },
        success: function (res) {
            if (res == true) {
                console.log(res);
                return;
            }
            location.href = `${URL_PETICION_MENUS}/${id}/menus`;
            return;
        },
        error: function (err) {
            console.log({ err });
            return;
        },
    });
};

const changeStatusModule = async (id) => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/${id}`,
        method: "PUT",
        success: function (res) {
            console.log(res);
            $(".table").load(location.href + " .table");
        },
        error: function (err) {
            $(".table").load(location.href + " .table");
        },
    });
    return;
};

const validationDataBase = async () => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/validationdb`,
        method: "POST",
        success: function (res) {
            console.log({ res });
            showNotification(
                "success",
                "Validacion de datos Realizada Exitosamente."
            );
            return;
        },
        error: function (err) {
            console.log({ err });
            showNotification("error");
            return;
        },
    });
};

function resetModal(etiquetaPermiso) {
    $(etiquetaPermiso).modal("hide");
    $(".table").load(location.href + " .table");
}
