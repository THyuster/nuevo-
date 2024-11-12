const camposExcluir = ['id','created_at','updated_at', 'municipio_id'];
const URL_PETICION_MODULOS = `${constante.HOST}/modulo_contabilidad/sucursales`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const buttonsModal = {
    "idEditModal": "#editBranch",
    "idDeleteModal": "#deleteModalBranch",
    "idCreateModal": "#createBranch",
    
};

const btnModalButtonsActions = {
    "create": "#btnCreateBranch",
    "delete": "#deleteConfirmButton",
    "edit": "#btnEditBranch",
    "updateState":"#estado"
};

const obtenerDataTable = function (tbody, table) {
    $(tbody).on("click", "#edit", function () {
        let data = table.row($(this).parents("tr")).data();
        
        $("#floatingDescripcionUpdate").val(data.sucursal);
        $("#floatingCodigoUpdate").val(data.codigo);
        $("#idSucursalUpdate").val(data.municipio_id);
        $("#empresaIdUpdate").val(data.empresa_id);
        
        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#delete", function () {
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
    });

    $(tbody).on("click", "#estado", function (e) {
        e.preventDefault();
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
        
        estado($(this));
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
            
            resetModal("#deleteModalBranch")
            showNotification("deleted");
            button.prop('disabled', false);
        },
        error:function (err){
            
            resetModal("#deleteModalBranch")
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
        "municipio_id":$("#idSucursalUpdate :selected").val(),
        "empresa_id": $("#empresaIdUpdate :selected").val(),
    }
    
    const id = localStorage.getItem('id')
    
     $.ajax({
        url:`${URL_PETICION_MODULOS}/${id}`,
        method:'PUT',
        data,
        success:function(res){
            
            resetModal("#editBranch")
            showNotification("success", res);
            button.prop('disabled', false);
        },
        error:function (err){
            
            resetModal("#editBranch")
            showNotification("error", err.responseJSON.message);
            button.prop('disabled', false);
        }
    })
})

// Servicio de crear
$(btnModalButtonsActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop('disabled', true);
    const data = {
        "codigo": $("#floatingCodigo").val(),
        "descripcion": $("#floatingDescripcion").val(),
        "municipio_id":$("#idSucursal :selected").val(),
        "empresa_id": $("#empresa_id :selected").val(),
    };
    
    
   $.ajax({
        url:URL_PETICION_MODULOS,
        method:'POST',
        data,
        success:function(res){
            
            resetModal("#createBranch")
            button.prop('disabled', false);
            showNotification("success");
            $("#formPermisosCrear")[0].reset();
            
        },
        error:function (err){
            
            resetModal("#createBranch")
            button.prop('disabled', false);
            showNotification("error", err.responseJSON.message);
        }
    })
})
   
    
   function estado(e) {
    let button = e;
    button.prop('disabled', true);
     let id = localStorage.getItem('id')
     
    $.ajax({
        url:`${URL_PETICION_MODULOS}/${id}/updateStatus`,
        method:'PUT',
        success:function(res){
            
            resetModal("#deleteModalBranch")
            showNotification("success");
            button.prop('disabled', false);
        },
        error:function (err){
            
            button.prop('disabled', false);
            resetModal("#deleteModalBranch")
            showNotification("error");
        }
    })
   }

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(`${URL_PETICION_MODULOS}/show`,buttonsModal, "#compactData", camposExcluir);
        return;
    }
    cargarDatos(`${URL_PETICION_MODULOS}/show`,buttonsModal, "#compactData", camposExcluir);
    return;
}