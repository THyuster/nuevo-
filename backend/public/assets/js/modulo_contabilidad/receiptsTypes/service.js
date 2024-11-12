const URL_PETICION_MODULOS = `${constante.HOST}/contabilidad/tipos_comprobantes`


$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});


const camposExcluir = [];
const orden = [];


const buttonsModal = {
    idCreateModal: "#createTypeReceipt",
    idEditModal: "#updateTypeReceipt",
    idDeleteModal: "#deleteTypeReceipt",
   
};

const buttonModalActions = {
    create: "#btnCreateTypeReceipt",
    delete: "#btnDeletetypeReceipt",
    edit: "#btnUpdateTypeReceipt",
    
};

const obtenerDataTable = function (tbody, table) {
    
    $(tbody).on("click", "#edit", function () {
        let data = table.row($(this).parents("tr")).data();
        console.log({data})
        for (let objeto in data) {
            if (data.hasOwnProperty(objeto)) {
                let valor = data[objeto];
                if ($(`#updateTypeReceipt input[name="${objeto}"]`).length) {
                    $(`#updateTypeReceipt input[name="${objeto}"]`).val(valor);
                }
                // if ($(`#updateTypeReceipt select[name="${objeto}"]`).length) {
                //     $(`#updateTypeReceipt select[name="${objeto}"]`).val(valor);
                // }
            };
        };

        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#signo", function (e){
        e.preventDefault();
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id)
        changeSignOrStatus($(this), 'updateSign');    
    })
    $(tbody).on("click", "#estado", function (e){
        e.preventDefault();
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id)
        changeSignOrStatus($(this), 'updateStatus');    
    })
    
    $(tbody).on("click", "#delete", function () {
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
    });
    
}




$(buttonModalActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);

    let formulario = $("#createTypeReceiptForm")[0];
    let formData = new FormData(formulario);

    $.ajax({
        url: `${URL_PETICION_MODULOS}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log({response});
            resetModal(buttonsModal.idCreateModal);
            button.prop("disabled", false);
            showNotification("success");
            $("#createTypeReceipt")[0].reset();
            return;
        },
        error: function (err) {
            console.log({err});
            resetModal(buttonsModal.idCreateModal);
            button.prop("disabled", false);
            showNotification("error", err.responseJSON.message);
        },
    });
});
$(buttonModalActions.edit).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);

    
    let formulario = $("#updateTypeReceiptForm")[0];
    let formData = new FormData(formulario);

    let id = localStorage.getItem("id");

    $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
        
            resetModal(buttonsModal.idEditModal);
            button.prop("disabled", false);
            showNotification("success");
            $("#updateTypeReceiptForm")[0].reset();
            return;
        },
        error: function (err) {
            console.log({err});
            resetModal(buttonsModal.idEditModal);
            button.prop("disabled", false);
            showNotification("error", err.responseJSON.message);
        },
    });
});



$(buttonModalActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    let id = localStorage.getItem("id");
    $.ajax({
        url: `${URL_PETICION_MODULOS}/${id}/delete`,
        method: "DELETE",
        success: function (response) {
            console.log({response});            
            resetModal(buttonsModal.idDeleteModal);
            button.prop("disabled", false);
            showNotification("success");

            return;

        },
        error: function (err) { 
            resetModal(buttonsModal.idDeleteModal);
            button.prop("disabled", false);
            showNotification("error", err.responseJson.message);
        },
    });
});



function changeSignOrStatus(e, endPoint){
    const id = localStorage.getItem("id");
    e.prop("disabled", true);
   
    $.ajax({
        url:`${URL_PETICION_MODULOS}/${id}/${endPoint}`,
        method:'PUT',
        success:function(res){
            console.log({res});
            resetModal(null);
            e.prop("disabled", true);
            return;
        },
        error: function (err) {
            console.log(err);
            showNotification("error");
        },

    })

}


const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#compactData", camposExcluir);
        return;
    }
    cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#compactData", camposExcluir);
    return;
};