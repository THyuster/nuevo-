//Acción de borrar y confirmar a través de modal de modulos
$(document).on("click", ".btn-delete", function (e) {
    const dataid = $(this).data("id");
    localStorage.setItem("dataid", dataid);
});
//Llamado del item en modulos
$(document).on("click", ".delete", function (e) {
    e.preventDefault();
    deleteModule(localStorage.getItem("dataid"));
});
//Escucha de botón en modal de creación de Modulo
$(document).on("click", "#btnCreateModule", function (e) {
    e.preventDefault();
    let idFormulario = "formPermisosCrear";
    let formulario = $(`#${idFormulario}`)[0];
    formulario = new FormData(formulario);
    createModule(formulario);
});
//Abrir modal de edicion de modulo
$(document).on("click", ".editFormModule", function (e) {
    console.log($(this).data("tipo_acceso"));
    e.preventDefault();
    sessionStorage.clear();

    $("#formPermisosEditar input[name=descripcion]").val($(this).data("descripcion"));
    $("#formPermisosEditar input[name=orden]").val($(this).data("orden"));
    $("#formPermisosEditar input[name=ubicacion]").val($(this).data("ubicacion"));
    $("#formPermisosEditar select[name=tipo_usuario]").val($(this).data("tipo_acceso"));

    localStorage.setItem("id", $(this).data("id"))
});
//Función de modal editar modulos
$(document).on("click", "#btnEditModules", async function (e) {
    e.preventDefault();
    let idFormulario = "formPermisosEditar";
    let formulario = $(`#${idFormulario}`)[0];
    formulario = new FormData(formulario);
    formulario.append("id", localStorage.getItem("id"));
    await editModule(formulario);
});
//Función de activo/inactivo
$(document).on("click", "#btnState", async function (e) {
    e.preventDefault();
    await changeStatusModule($(this).data("id"));
});


$(document).on("click", "#validarbd", async function (e) {
    showNotification("loading", "Proceso de Validacion de Datos, Iniciado.");
    e.preventDefault();
    await validationDataBase();
});

$(document).on("click", ".changeRouter", async function (e) {
    e.preventDefault();

    await linkMenu($(this).data("id"));
});
