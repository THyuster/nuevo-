const url = location.href + "/show";

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const camposExcluir = ["id", "sucursal_id", "grupo_contable_id", "grupo_articulo_id", "tipo_articulo_id", "unidad_id",
    "marca_id", "fecha_actualizacion"];

const orden = ["codigo", "descripcion", "marca", "tipo_articulo", "grupo_articulo", "unidad", "grupo_contable", "observaciones"];

const buttonsModal = {
    idEditModal: "#ArticuloEdit",
    idDeleteModal: "#deleteArticle",
    idCreateModal: "#ArticuloCreate",
};

const buttonModalActions = {
    edit: "#btnArticuloEdit",
    delete: "#btnDeleteArticle",
    create: "#btnArticuloCreate",
};

const obtenerDataTable = function (tbody, table) {

    $(tbody).on("click", "#edit", function () {

        let rowNode = table.row(this).node();
        let data = table.row(rowNode).data();

        let fechaHora = data.fecha_actualizacion.split(' ');
        
        $("#formArticuloEdit input[name='ruta_imagen']").val('');
        $("#formArticuloEdit input[name='fecha_modificacion']").val(fechaHora[0]);
        $("#formArticuloEdit img[id='imagenPrevisualizacion']").attr('src', data.ruta_imagen);

        for (let objeto in data) {
            if (data.hasOwnProperty(objeto)) {

                let valor = data[objeto];

                if ($(`#formArticuloEdit input[name="${objeto}"]`).length && $(`#formArticuloEdit input[name="${objeto}"]`).attr('type') !== 'file') {
                    $(`#formArticuloEdit input[name="${objeto}"]`).val(valor);
                }

                if ($(`#formArticuloEdit select[name="${objeto}"]`).length) {
                    $(`#formArticuloEdit select[name="${objeto}"]`).val(valor);
                }

                if ($(`#formArticuloEdit textarea[name="${objeto}"]`).length) {
                    $(`#formArticuloEdit textarea[name="${objeto}"]`).val(valor);
                }
            };
        };

        localStorage.setItem("id", data.id);

    });

    $(tbody).on("click", "#delete", function () {

        let rowNode = table.row(this).node();
        let data = table.row(rowNode).data();

        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#estado", function (e) {
        let rowNode = table.row(this).node();
        let data = table.row(rowNode).data();
        localStorage.setItem("id", data.id);
        changeEstado($(this));
    });
};

$(buttonModalActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let id = localStorage.getItem("id");
    $.ajax({
        url: location.href + `/delete/${id}`,
        method: "DELETE",
        success: function (response) {
            if (response == "elimino") {
                resetModal(buttonsModal.idDeleteModal);
                button.prop("disabled", false);
                localStorage.clear();
                showNotification("deleted");
                return;
            }
            resetModal(buttonsModal.idDeleteModal);
            button.prop("disabled", false);
            localStorage.clear();
            showNotification("error", response);
            return;
        },
        error: function () { },
    });
});

// Función para editar un registro
$(buttonModalActions.edit).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);

    let formulario = $("#formArticuloEdit")[0];
    let formData = new FormData(formulario);

    let id = localStorage.getItem("id");

    $.ajax({
        url: location.href + `/update/${id}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            if (response == "Actualizo") {
                resetModal(buttonsModal.idEditModal);
                // button.prop("disabled", false);
                button.prop("disabled", false);
                localStorage.clear();
                showNotification("updated");
                return;
            }
            resetModal(buttonsModal.idEditModal);
            localStorage.clear();
            showNotification("error", response);
            return;
        },
        error: function (error) {
            console.log(error);
            button.prop("disabled", false);

        },
    });
});

function changeEstado(e) {
    let id = localStorage.getItem("id");
    e.prop("disabled", true);
    $.ajax({
        url: location.href + `/estado/${id}`,
        method: "PUT",
        success: function (response) {
            console.log(response);
            showNotification("loading");
            resetModal(null);
            e.prop("disabled", true);
            localStorage.clear();
            showNotification("success");
            return;
        },
        error: function (error) {
            console.log(error);
            showNotification("erro");
        },
    });
}

$(buttonModalActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);

    let formulario = $("#formArticuloCreacion")[0];
    let formData = new FormData(formulario);

    $.ajax({
        url: location.href,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response == "Creo") {
                resetModal(buttonsModal.idCreateModal);
                localStorage.clear();
                button.prop("disabled", false);
                showNotification("success");
                $("#formArticuloCreacion")[0].reset();
                let urlImagenDefault = 'http://181.48.57.46:8083/imagenes/Sgju118SpEmmjMjy0n6pHmhKhmnNaWpPQoUHw2oGio4In60Le5F82SGDioQ2dHyKN6JUp1tIPyRz1jYYNZLJQlEDeSYOU2JZe21ysZu3JHSDESmY17dNyfYI.png'
                $("#formArticuloCreacion img[id='imagenPrevisualizacion']").attr('src', urlImagenDefault);
                return;
            }
            resetModal(buttonsModal.idCreateModal);
            button.prop('disabled', false);
            localStorage.clear();
            showNotification("error", response);
            return;
        },
        error: function (error) {
            console.log(error);
            button.prop("disabled", false);
        },
    });
});

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(url, buttonsModal, "#tabla", camposExcluir, orden);
        return;
    }
    cargarDatos(url, buttonsModal, "#tabla", camposExcluir, orden);
    return;
};

$("#formArticuloEdit input[name='ruta_imagen']").change(function (event) {

    let archivo = event.target.files[0];
    let lector = new FileReader();
    lector.onload = function (e) {
        $("#formArticuloEdit img[id='imagenPrevisualizacion']").attr('src', e.target.result).show();
    };
    lector.readAsDataURL(archivo);
});

$("#formArticuloCreacion input[name='ruta_imagen']").change(function (event) {
    let archivo = event.target.files[0];
    let lector = new FileReader();
    lector.onload = function (e) {
        $("#formArticuloCreacion img[id='imagenPrevisualizacion']").attr('src', e.target.result).show();
    };
    lector.readAsDataURL(archivo);
});

