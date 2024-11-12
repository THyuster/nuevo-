//confirmación de eliminación en modal de menu
$(document).on("click", "#deleteMenu", function (e) {
    e.preventDefault();
    let boton = e.currentTarget;
    boton.disabled = true;
    deleteMenus(localStorage.getItem("idMenu"));
    boton.disabled = false;
    localStorage.clear();
});

$(document).on("click", "#btnDeleteMenu", function (e) {
    localStorage.clear();
    e.preventDefault();
    localStorage.setItem("idMenu", $(this).data("id"))
})

$(document).on("click", ".create_menu", function (e) {
    e.preventDefault();
    localStorage.clear()
    localStorage.setItem("modulo_id", $(this).data("modulo_id"));
})
//confirmación de la creacion del menu con confirmación de boton en modal
$(document).on("click", "#btnCreateMenu", function (e) {
    e.preventDefault();
    let boton = e.currentTarget;
    boton.disabled = true;
    const jsonData = {
        "modulo_id": localStorage.getItem("modulo_id"),
        "descripcion": document.getElementById("floatingDescripcion").value,
        "orden": document.getElementById("floatingOrden").value,
    };
    localStorage.clear();
    createMenus(jsonData);
    boton.disabled = false;
});
//Apertura de modal de edición de menus
$(document).on("click", "#editMenu", function (e) {
    e.preventDefault();
    localStorage.clear();
    localStorage.setItem("id_menu", $(this).data("id"));
    $("#floatingDescripcionUpdate").val($(this).data("nombre"));
    $("#floatingOrdenUpdate").val($(this).data("orden"));
});
//Acción de confirmar edición al oprimir en modal confirmar edición
$(document).on("click", "#btnEditMenu", function (e) {
    e.preventDefault();
    let boton = e.currentTarget;
    boton.disabled = true;
    const jsonData = {
        id: localStorage.getItem("id_menu"),
        descripcion: $("#floatingDescripcionUpdate").val(),
        orden: $("#floatingOrdenUpdate").val(),
    };
    localStorage.clear();
    updateMenus(jsonData);
    boton.disabled = false;

});
//Acción de cambio de estatus activo o inactivo en menu
$(document).on("click", "#btnStatusChangeMenu", async function (e) {
    e.preventDefault();
    let boton = e.currentTarget;
    boton.disabled = true;
    await changeStatus($(this).data("id"));
    boton.disabled = false;
    return;
});

//Llamar el subMenu por medio del botón #submenu
$(document).on("click", "#submenu", function (e) {
    e.preventDefault();
    btnSubmenus($(this).data("id"));
})
