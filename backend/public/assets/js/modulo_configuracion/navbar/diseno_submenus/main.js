

$(document).on("click","#crear",function (e) {
    e.preventDefault();
    localStorage.setItem("idMenu",$(this).data("id"));
    
});

$(document).on("click","#delete", function (e){
    e.preventDefault();
    localStorage.setItem("idsubmenu",$(this).data("id"));
});

$(document).on("click", "#DeleteSubmenu", function (e) {
    e.preventDefault();
    let boton = e.currentTarget;
    boton.disabled=true;
    deleteMenus(localStorage.getItem("idsubmenu"));
    boton.disabled=false;
});

//Confirmación de creación de submenu con botón de creación en modal.
$(document).on("click", "#btnCreateSubmenu", function (e) {
    e.preventDefault();
    let boton = e.currentTarget;
    boton.disabled=true;
    const jsonData = {
        descripcion: document.getElementById("floatingDescripcion").value,
        orden: document.getElementById("floatingOrden").value,
    };
    createMenus(localStorage.getItem("idMenu"),jsonData);
    boton.disabled=false;
});

$(document).on("click", ".editForm", function (e) {
    e.preventDefault();
    localStorage.clear();
    localStorage.setItem("idsubMenuActu", $(this).data("id"));
    localStorage.setItem("idsubMenuidMenuActu", $(this).data("idmenu"));
    console.log(localStorage.getItem("idsubMenuidMenuActu"));
    $("#floatingDescripcionUpdate").val($(this).data("name"));
    $("#floatingOrdenUpdate").val($(this).data("orden"));
});

$(document).on("click", "#btneditSubmenu", function (e) {
    e.preventDefault();
    let boton = e.currentTarget;
    boton.disabled=true;
    const jsonData = {
        idMenu : localStorage.getItem("idsubMenuidMenuActu"),
        descripcion: $("#floatingDescripcionUpdate").val(),
        orden:$("#floatingOrdenUpdate").val()
    };
    updateMenus(localStorage.getItem("idsubMenuActu"),jsonData);
    boton.disabled=false;
    localStorage.clear();
});

$(document).on("click", "#statusChange", async function (e) {
    e.preventDefault();
    let boton = e.currentTarget;
    boton.disabled=true;
    await changeStatus($(this).data("id"));
    boton.disabled=false;
    return;
});

$(document).on("click",".routeView", function (e) {
    e.preventDefault();
    btnViews($(this).data("id"))
})

