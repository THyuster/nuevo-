URL_PETICION_MODULOS = `${constante.HOST}/su_administrador/diseno_submenus`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
//Función de creación de menus
const createMenus = async (id, jsonData) => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/create/${id}`,
        method: 'POST',
        data: jsonData,
        success: function (res) {
            console.log({res})
            showNotification("success");
            resetModal("#CreateSubmenu")
            return;
        },
        error: function (err) {
            console.log(err.responseJSON.message)
            resetModal("#CreateSubmenu")
            return;
            //showNotification(err);
        },
    })
}

const updateMenus = async (id,jsonData) => {
    
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: 'PUT',
        data: jsonData,
        success: function (res) {
            console.log(res);
            showNotification("updated");
            resetModal("#editSubmenu");
            return;
        },
        error: function (err) {
            showNotification("error");
            resetModal("#editSubmenu");
            return;
        },
    })
}

const changeStatus = async (id) => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/status/${id}`,
        method: 'PUT',
        success: function (res) {
            console.log(res);
            showNotification("updated");
            resetModal();
            return;
        },
        error: function (err) {
            showNotification("error");
            resetModal();
            return;
        },
    })
}

const deleteMenus = async (id) => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/destroy/${id}`,
        method: "DELETE",
        success: function (res) {
            showNotification("deleted");
            resetModal("#deleteSubmenuModal");
            return;
        },
        error: function (err) {
            console.log(err.responseJSON)
            showNotification("error");
            resetModal()
            return;
        },
    });
}

const btnViews = async (id) => {
    
    await $.ajax({
        url: `${constante.HOST}/su_administrador/diseno_vistas/vistas/${id}`,
        method: "GET",
        success: function (res) {
            location.href = `${constante.HOST}/su_administrador/diseno_vistas/vistas/${id}`;
            return;
        },
        error: function (err) {
            console.log(err.responseJSON)
            showNotification("error");
            resetModal()
            return;
        },
    })
}

function resetModal(modal) {
    $(modal).modal("hide");
    $(".table").load(location.href + " .table");
    return;
}
