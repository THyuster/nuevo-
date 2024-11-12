/*BOTON CREAR Y DATA MIGRACION*/
$(document).on("click", "#btnCreateMigration", function (e) {
    e.preventDefault();
    const jsonData = {
        tabla: document.getElementById("floatingTabla").value,
        campo: document.getElementById("floatingCampo").value,
        atributo: document.getElementById("floatingAtributo").value,
        accion: document.getElementById("floatingAccion").value,
        script_db: document.getElementById("floatingScript").value,
        estado: true,
    };
    //console.log(jsonData);
    createMigracion(jsonData);
});

// Captura de datos del registro
$(document).on("click", "#actualizarMigracion", function (e) {
    e.preventDefault();
    // El id de la tabla se almacena en localStorage
    console.log($(this).data("accion"));
    console.log($(this).data("script_db"));
    
    localStorage.setItem("idMigracion", $(this).data("id"));
    $("#floatingTablaUpdate").val($(this).data("tabla"));
    $("#floatingCampoUpdate").val($(this).data("campo"));
    $("#floatingAtributoUpdate").val($(this).data("atributo"));
    $("#floatingAccionUpdate").val($(this).data("accion"));
    $("#floatingScriptUpdate").val($(this).data("script_db"));
});

/*BOTON EDITAR MIGRACION*/
$(document).on("click", "#btnUpdateMigracion", async function (e) {
    e.preventDefault();
    const data = {
        tabla: $("#floatingTablaUpdate").val(),
        campo: $("#floatingCampoUpdate").val(),
        atributo: $("#floatingAtributoUpdate").val(),
        accion: $("#floatingAccionUpdate").val(),
        script_db: $("#floatingScriptUpdate").val(),
    };
    await editMigracion(localStorage.getItem("idMigracion"), data);
    localStorage.clear();
});

/*CAPTURA DEL ID DE ELIMINACION*/
$(document).on("click", "#modalDeleteMigration", function (e) {
    localStorage.clear();
    e.preventDefault();
    localStorage.setItem("id", $(this).data("id"));
});

/*MODAL DE CONFIRMACION DE ELIMINACION*/

/* BOTON ELIMINACION DE MIGRACION*/

$(document).on("click", "#btnDeleteMigration", function (e) {
    e.preventDefault();
    console.log(localStorage.getItem("id"));

    deleteMigration(localStorage.getItem("id"));
    localStorage.clear();
    // resetModal("#modalDeleteMigration", null , ".table");
    showNotification("deleted");
});


$(document).on("click", ".editForm", function (e) {
    e.preventDefault();
    sessionStorage.clear();
    const data = {
        id: $(this).data("id"),
        codigo: $(this).data("codigo"),
        descripcion: $(this).data("descripcion"),
        orden: $(this).data("orden"),
        ubicacion: $(this).data("ubicacion"),
    };
    // $("floatingDescripcionUpdate").text()
    $("#floatingDescripcionUpdate").val($(this).data("descripcion"));
    $("#floatingOrdenUpdate").val($(this).data("orden"));
    $("#floatingUbicacionUpdate").val($(this).data("ubicacion"));

    sessionStorage.setItem("data_edit_diseno_menus", JSON.stringify(data));
});




$(document).on("click", "#btnState", async function (e) {
    e.preventDefault();
    sessionStorage.clear();
    const jsonDataWhere = {
        id: $(this).data("id"),
        codigo: $(this).data("codigo"),
        descripcion: $(this).data("descripcion"),
        orden: $(this).data("orden"),
        ubicacion: $(this).data("ubicacion"),
        script_db: $(this).data("script_db"),
    };
    const jsonDataUpdate = {
        estado: $(this).text(),
    };
    await changeStatusModule(jsonDataUpdate, jsonDataWhere);
});



$(document).on("click", "#validarbd", async function (e) {
    showNotification("loading");
    e.preventDefault();
    await validarDb();
    console.log("click");
    showNotification("success");
});

// const myButton = document.getElementById('btnState');
// myButton.addEventListener('click', function() {
//     if (myButton.classList.contains('Activo')) {
//         myButton.classList.remove('Activo');
//         myButton.textContent = 'Inactivo';
//     } else {
//         myButton.classList.add('Activo');
//         myButton.textContent = 'Activo';
//     }
// });
