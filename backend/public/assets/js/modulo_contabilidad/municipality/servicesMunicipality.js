const URL_PETICION_MODULOS = `${constante.HOST}/modulo_contabilidad/municipios`;


$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

createMunicipality = async (jsonData)=>{
    
    await $.ajax({
        url:URL_PETICION_MODULOS,
        method:'POST',
        data:jsonData,
        success:function(res){
            console.log({res})
            resetModal("#createMunicipality")
            showNotification("success");
        },
        error:function (err){
            console.log({err})
            resetModal("#createMunicipality")
            showNotification("error");
        }
    })
}

updateMunicipality = async (id, jsonData)=>{
    
    await $.ajax({
        url:`${URL_PETICION_MODULOS}/${id}`,
        method:'PUT',
        data:jsonData,
        success:function(res){
            console.log({res})
            resetModal("#editMunicipality")
            showNotification("success");
        },
        error:function (err){
            console.log({err})
            resetModal("#editMunicipality")
            showNotification("error");
        }
    })
}

deleteMunicipality = async (id)=>{
      await $.ajax({
        url:`${URL_PETICION_MODULOS}/${id}`,
        method:'DELETE',
        success:function(res){
            console.log({res})
            resetModal("#deleteMunicipality")
            showNotification("deleted")
        },
        error:function (err){
            console.log({err})
            resetModal("#deleteMunicipality")
            showNotification("error")
        }
    })
}


function resetModal(modal) {
    $(modal).modal("hide");
    $(".table").load(location.href + " .table");
    return;
}
