const camposExcluir = ['id','created_at','updated_at','departamento_id'];
const URL_PETICION_MODULOS = `${constante.HOST}/modulo_contabilidad/municipios`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const buttonsModal = {
    "idEditModal": "#editMunicipality",
    "idDeleteModal": "#deleteMunicipality",
    "idCreateModal": "#createMunicipality"
};

const btnModalButtonsActions = {
    "create": "#btnCreateMunicipality",
    "delete": "#btnDeletemunicipality",
    "edit": "#btnEditMunicipality",
};

const obtenerDataTable = function (tbody, table) {
    $(tbody).on("click", "#edit", function () {
        let data = table.row($(this).parents("tr")).data();
        
        $("#floatingDescripcionUpdate").val(data.descripcion);
        $("#floatingCodigoUpdate").val(data.codigo);
        $("#idDepart").val(data.departamento_id);
        
        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#delete", function () {
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
    });
}

// Servicio de eliminar
$(btnModalButtonsActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this)
    button.prop('disabled', true);
    let id = localStorage.getItem('id')
     $.ajax({
        url:`${URL_PETICION_MODULOS}/${id}`,
        method:'DELETE',
        success:function(res){
            console.log({res})
            resetModal(buttonsModal.idDeleteModal)
            showNotification("error", res)
            button.prop('disabled', false);
        },
        error:function (err){
            console.log({err})
            showNotification(buttonsModal.idDeleteModal)
            showNotification("error", err.responseJSON.message);
            button.prop('disabled', false);
        }
    })
})

// Servicio de editar
$(btnModalButtonsActions.edit).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop('disabled', true);
    let data = {
        "codigo": $("#floatingCodigoUpdate").val(),
        "descripcion": $("#floatingDescripcionUpdate").val(),
        "departamento_id":$("#idDepart :selected").val(),
    }
    let id = localStorage.getItem('id')
    
    $.ajax({
        url:`${URL_PETICION_MODULOS}/${id}`,
        method:'PUT',
        data,
        success:function(res){
            console.log({res})
            resetModal(buttonsModal.idEditModal)
            showNotification("success");
            
        },
        error:function (err){
            console.log({err})
            resetModal(buttonsModal.idEditModal)
            showNotification("error");
        }
    })
})

// Servicio de crear
$(btnModalButtonsActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop('disabled', true);
    let data = {
        "codigo": $("#floatingDescripcion").val(),
        "descripcion": $("#floatingDepartament").val(),
        "departamento_id":$("#idDepartament :selected").val(),
    };
    
    $.ajax({
        url:URL_PETICION_MODULOS,
        method:'POST',
        data,
        success:function(res){
            console.log({res})
            resetModal("#createMunicipality")
            showNotification("success");
            $("#formPermisosCrear")[0].reset()
        },
        error:function (err){
            console.log({err})
            resetModal("#createMunicipality")
            showNotification("error", err.responseJSON.message);
            
        }
    })
})

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(`${URL_PETICION_MODULOS}/show`, buttonsModal, "#tabla", camposExcluir);
        return;
    }
    cargarDatos(`${URL_PETICION_MODULOS}/${show}`, buttonsModal, "#tabla", camposExcluir);
    return;
}