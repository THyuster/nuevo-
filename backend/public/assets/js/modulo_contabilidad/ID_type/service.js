const camposExcluir = ["id", "created_at", "updated_at"];
const URL_PETICION_MODULOS = `${constante.HOST}/modulo_contabilidad/tipos_identificaciones`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const buttonsModal = {
    idCreateModal: "#ID_TypeCreate",
    idEditModal: "#ID_TypeEdit",
    idDeleteModal: "#ID_TypeDelete",
};

const btnModalButtonsActions = {
    create: "#ID_TypeCreateBtn",
    edit: "#ID_TypeEditBtn",
    delete: "#ID_TypeDeleteBtn",
};

const obtenerDataTable = function (tbody, table) {
    $(tbody).on("click", "#edit", function () {
        let data = table.row($(this).parents("tr")).data();
        $("#floatingDescripcionUpdate").val(data.descripcion);
        $("#floatingCodigoUpdate").val(data.codigo);
        // $("#idSucursalUpdate").val(data.sucursal_id);
        // console.log(data);
        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#delete", function () {
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
    });
};

// Servicio de eliminar
$(btnModalButtonsActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let id = localStorage.getItem("id");
    $.ajax({
        url: `${URL_PETICION_MODULOS}/${id}`,
        method: "DELETE",
        success: function (res) {
            console.log({ res });
            resetModal(buttonsModal.idDeleteModal);
            showNotification("deleted");
            button.prop("disabled", false);
        },
        error: function (err) {
            console.log({ err });
            resetModal(buttonsModal.idDeleteModal);
            showNotification("error");
            button.prop("disabled", false);
        },
    });
});

// Servicio de editar
$(btnModalButtonsActions.edit).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let data = {
        codigo: $("#floatingCodigoUpdate").val(),
        descripcion: $("#floatingDescripcionUpdate").val(),
    };
    let id = localStorage.getItem("id");
    console.log("editar ", data);
    $.ajax({
        url: `${URL_PETICION_MODULOS}/${id}`,
        method: "PUT",
        data,
        success: function (res) {
            console.log({ res });
            resetModal(buttonsModal.idEditModal);
            showNotification("success");
        },
        error: function (err) {
            console.log(err.responseJSON);
            resetModal("#editDept");
            showNotification("error", err.responseJSON.message);
        },
    });
});

// Servicio de crear
$(btnModalButtonsActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let data = {
        codigo: $("#floatingCodigo").val(),
        descripcion: $("#floatingDescripcion").val(),
    };

    $.ajax({
        url: URL_PETICION_MODULOS,
        method: "POST",
        data,
        success: function (res) {
            console.log({ res });
            resetModal(buttonsModal.idCreateModal);
            showNotification("success");
            button.prop("disabled", false);
            $("#formPermisosCrear")[0].reset();
        },
        error: function (err) {
            console.log({ err });
            button.prop("disabled", false);
            resetModal("#createDept");
            showNotification("error", err.responseJSON.message);
        },
    });
});

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(
            `${URL_PETICION_MODULOS}/show`,
            buttonsModal,
            "#compactData",
            camposExcluir
        );
        return;
    }
    cargarDatos(
        `${URL_PETICION_MODULOS}/show`,
        buttonsModal,
        "#compactData",
        camposExcluir
    );
    return;
};
