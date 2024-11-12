localStorage.clear();

$(document).on("click", "#btnCreatePermission", async function (e) {
    let botonCrear = e.currentTarget;
    e.preventDefault();

    if ($("#idUsuarioAsignacion :selected").val() == "Seleccione" || $("#idModuloAsignacion :selected").val() == "Seleccione") {
        return;
    }
    botonCrear.disabled=true;
    jsonData = {
        "idUsuario": $("#idUsuarioAsignacion :selected").val(),
        "idModulo": $("#idModuloAsignacion :selected").val(),
        "Usuario": $("#idUsuarioAsignacion :selected").text(),
        "Modulo": $("#idModuloAsignacion :selected").text(),
    };
    await createAsignation(jsonData);
    
    botonCrear.disabled = false;
});

$(document).on("click", ".editForm", function (e) {
    e.preventDefault();
    localStorage.clear();
    localStorage.setItem("id_usuario_modulo", $(this).data("id"));
    localStorage.setItem("id_user", $(this).data("userid"));
    localStorage.setItem("previos", $(this).data("previos"));
    $("#nombreUsuario").text($(this).data("nombre"));
    $("#previosModule").text($(this).data("previos"));
    
    
});

$(document).on("click", "#btnUpdatePermission", async function (e) {

    let boton = e.currentTarget;
    boton.disabled=true;
    e.preventDefault();
    const jsonData = {
        "id_usuario_modulo": localStorage.getItem("id_usuario_modulo"),
        "moduloName":$("#modulosSelect").val(),
        "idUsuario": localStorage.getItem("id_user"),
        "previos": localStorage.getItem("previos")
    }
    const id = localStorage.getItem("id_usuario_modulo");
    await updateAsignation(id, jsonData);
    boton.disabled=false;
});

$(document).on("click","#deleteBtn",function(){
    localStorage.clear();
    localStorage.setItem("id_usuario_delete", $(this).data("id"));
    console.log();
})

$(document).on("click","#deleteConfirmButton", async function (e){
    e.preventDefault();
    let boton = e.currentTarget;
    boton.disabled=true;
    await deleteAsignation(localStorage.getItem("id_usuario_delete"))
    boton.disabled=false;
})