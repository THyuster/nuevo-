const camposExcluir = [
    "id"
    
];

const orden = [
 
];

const URL_PETICION_MODULOS = `${constante.HOST}/activos_fijos/equipos`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});


const buttonsModal = {
    idCreateModal: "#createDevices",
    idEditModal: "#updateDevice",
    idDeleteModal: "#deleteDevice",
};

const btnModalButtonsActions = {
    create: "#btnSaveDevice",
    edit: "#btnUpdateDevice",
    delete: "#btnDeleteDevice",
};

const obtenerDataTable = function (tbody, table) {
    $(tbody).on("click", "#edit", function () {
        const rowNode = table.row($(this)).node();
        const data = table.row(rowNode).data();
        console.log({data});
        
        $("#mainSpecsUpdate img[id='imagenPrevisualizacion']").attr(
            "src",
            data.ruta_imagen
        );
        localStorage.setItem("id", data.id);
        for (let objeto in data) {
            if (data.hasOwnProperty(objeto)) {
                let valor = data[objeto];
                console.log();
                if ($(`#mainSpecsUpdate input[name="${objeto}"]`).length && $(`#mainSpecsUpdate input[name="${objeto}"]`).attr("type") !== "file") {
                    $(`#mainSpecsUpdate input[name="${objeto}"]`).val(valor);
                }
                
                if (
                    $(`#mainSpecsUpdate select[name="${objeto}"]`).length
                ) {
                    $(`#mainSpecsUpdate select[name="${objeto}"]`).val(
                        valor
                    );
                }

                if (
                    $(`#mainSpecsUpdate textarea[name="${objeto}"]`)
                        .length
                ) {
                    $(`#mainSpecsUpdate textarea[name="${objeto}"]`).val(
                        valor
                    );
                }
            }
        }
    });

    $(tbody).on("click", "#delete", function () {
        const rowNode = table.row($(this)).node();
        const data = table.row(rowNode).data();
        localStorage.setItem("id", data.id);
    });

    // $("#mainSpecs img[id='imagenPrevisualizacion']").attr(
    //     "src",
    //     data.ruta_imagen
    // );

    $(tbody).on("click", "#estado", function () {
        let rowNode = table.row(this).node();
        let data = table.row(rowNode).data();
        
         localStorage.setItem("id", data.id);
        
        updateStatus($(this));
    });
}



// Servicio de crear
$(btnModalButtonsActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);

    button.prop("disabled", true);
    console.log('crear')

    let formulario = $("#mainSpecs")[0];
    let formData = new FormData(formulario);


    for (let pair of formData.entries()) {
        console.log(pair[0] + ": " + pair[1]);
    }
    
    $.ajax({
        url: URL_PETICION_MODULOS,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log({ res });
            showNotification("success");
            resetModal(buttonsModal.idCreateModal);
            $("#mainSpecs")[0].reset()
        },
        error: function (err) {
            console.log(err);
            showNotification("error", err.responseJSON.message);
            resetModal(buttonsModal.idCreateModal);
        },
    });
    button.prop("disabled", false);
});
$(btnModalButtonsActions.edit).on("click", function (e) {
    e.preventDefault();
    let button = $(this);

    button.prop("disabled", true);

    let id = localStorage.getItem("id");

    let formulario = $("#mainSpecsUpdate")[0];
    let formData = new FormData(formulario);

    console.log({id});

    $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log({ res });
            showNotification("success");
            resetModal(buttonsModal.idEditModal);
        },
        error: function (err) {
            console.log(err);
            showNotification("error", err.responseJSON.message);
            resetModal(buttonsModal.idEditModal);
        },
    });
    button.prop("disabled", false);
});

$(btnModalButtonsActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this);


    button.prop("disabled", true);
    let id = localStorage.getItem("id");
    
    $.ajax({
        url: `${URL_PETICION_MODULOS}/delete/${id}`,
        method: "DELETE",
        success: function (res) {
            console.log({ res });

            resetModal(buttonsModal.idDeleteModal);
            button.prop("disabled", false);
            showNotification("deleted");
        },
        error: function (err) {
            console.log({ err });
            resetModal(buttonsModal.idDeleteModal);
            button.prop("disabled", false);
            showNotification("error");
        },
    });

   
});


function updateStatus(e) {
    let button = e;
    button.prop("disabled", true);
    const id = localStorage.getItem("id");
    console.log("editar estatus ", `${URL_PETICION_MODULOS}/${id}/updateStatus`);
    $.ajax({
        url: `${URL_PETICION_MODULOS}/${id}/updateStatus`,
        method: "PUT",
        success: function (res) {
            console.log({ res });
            resetModal(null);
            showNotification("success");
        },
        error: function (err) {
            console.log(err.responseJSON);
            showNotification("error", err.responseJSON.message);
            resetModal(null);
        },
    });
}

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
        camposExcluir,
        orden
    );
    return;
};

$("#mainSpecsUpdate input[name='ruta_imagen']").change(function (event) {
    let archivo = event.target.files[0];
    let lector = new FileReader();
    lector.onload = function (e) {
        $("#mainSpecsUpdate  img[id='imagenPrevisualizacion']")
            .attr("src", e.target.result)
            .show();
    };
    lector.readAsDataURL(archivo);
});

$("#mainSpecs input[name='ruta_imagen']").change(function (event) {
    let archivo = event.target.files[0];
    let lector = new FileReader();
    lector.onload = function (e) {
        $("#mainSpecs img[id='imagenPrevisualizacion']")
            .attr("src", e.target.result)
            .show();
    };
    lector.readAsDataURL(archivo);
});
