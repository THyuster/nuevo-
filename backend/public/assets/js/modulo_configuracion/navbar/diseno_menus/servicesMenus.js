URL_PETICION_MODULOS = `${constante.HOST}/su_administrador/diseno_menus`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
//Función de crear menus
const createMenus = async (jsonData)=>{
    await $.ajax({
        url:`${URL_PETICION_MODULOS}`,
        method:'POST',
        data: jsonData,
        success: function (res) {
            console.log({res});
            showNotification("success");
            resetModal("#createMenus")
            return;
        },
        error: function (err) {
            console.log(err.responseJSON.message)
            resetModal("#createMenus")
            return;
            //showNotification(err);
        },
    })
}
//Función de actualizar Menus
const updateMenus = async (jsonData)=>{
   const {id}= jsonData
    await $.ajax({
        url:`${URL_PETICION_MODULOS}/${id}/update`,
        method:'PUT',
        data: jsonData,
        success: function (res) {
            showNotification("updated");
            resetModal("#editMenus")
            return;
        },
        error: function (err) {
            showNotification("error");
            resetModal("#editMenus")
            return;
        },
    })
}
//Cambio de estado activo/inactivo
const changeStatus = async (id)=>{
    await $.ajax({
        url:`${URL_PETICION_MODULOS}/${id}/checkStatus`,
        method:'PUT',
        success: function (res) {
            
            showNotification("updated");
            resetModal("#editarMenus")
            return;
        },
        error: function (err) {
            showNotification("error");
            resetModal("#editarMenus")
            return;
        },
    })
}
//Función de borrar menus
const deleteMenus =async (id)=>{
     await $.ajax({
        url: `${URL_PETICION_MODULOS}/${id}/delete`,
        method: "DELETE",
        success: function (res) {
            $("#deleteMenus").modal("hide");
            $(".table").load(location.href + " .table");
            showNotification("deleted");
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

const btnSubmenus = async (id) =>{
    const url =  `${constante.HOST}/su_administrador/diseno_submenus/${id}/submenus`
    await $.ajax({
        url,
        method: "GET",
        success: function (res) {
            location.href =url;
            console.log({res})
            return;
        },
        error: function (err) {
            console.log(err.responseJSON)
            console.log({err})
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
