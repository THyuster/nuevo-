$(document).ready(function (e) {
    localStorage.clear();
});

$(document).on("click", ".deleteView", function (e) {
    e.preventDefault();
    deleteView($(this).data("id"));
});

$(document).on("click", "#btnModalCrear", function (e) {
    e.preventDefault();
    localStorage.clear();
    localStorage.setItem("idSubmenu", $(this).data("id"));
});

$(document).on("click", "#btnCreateView", function (e) {
    e.preventDefault();

    const jsonData = {
        idSubmenu: localStorage.getItem("idSubmenu"),
        descripcion: document.getElementById("floatingDescripcion").value,
        ruta: document.getElementById("floatingUbicacion").value,
        orden: document.getElementById("floatingOrden").value
    };
    createView(jsonData);
    localStorage.clear();
});

$(document).on("click", ".editForm", function (e) {
    e.preventDefault();
    $("#floatingDescripcionUpdate").val($(this).data("name"));
    $("#floatingUbicacionUpdate").val($(this).data("ruta"));
    $("#floatingOrdenUpdate").val($(this).data("orden"));
    localStorage.setItem("idViews", $(this).data("id"));
    localStorage.setItem("idSubmenu", $(this).data("submenu_id"));
});

$(document).on("click", "#btnEditView", function (e) {
    e.preventDefault();
    const id = localStorage.getItem("idViews");
    const jsonUpdate = {
        idSubmenu: localStorage.getItem("idSubmenu"),
        descripcion: document.getElementById("floatingDescripcionUpdate").value,
        ruta: document.getElementById("floatingUbicacionUpdate").value,
        orden: document.getElementById("floatingOrdenUpdate").value,
    };
    updateView(id, jsonUpdate);
    localStorage.clear();
});

$(document).on("click", "#statusChange", function (e) {
    e.preventDefault();
    updateStatus($(this).data("id"));
    
});