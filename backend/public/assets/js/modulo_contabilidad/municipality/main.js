
$(document).on("click","#btnCreateMunicipality",function(e){

    e.preventDefault();
    const jsonData={
        departamento_id:$("#idDepartament :selected").val(),
        codigo:$("#floatingDescripcion").val(),
        descripcion: $("#floatingDepartament").val()
    }
    
    createMunicipality(jsonData)
});

$(document).on("click",".editFormMunicipality", function (e){
    e.preventDefault();
  $("#idDepart").val($(this).data("depid"));

    localStorage.setItem("id_municipality", $(this).data("id"));
    
    $("#floatingCodigoUpdate").val($(this).data("codigo"));
    $("#floatingDescripcionUpdate").val($(this).data("descripcion"));
    
});

$(document).on("click","#btnEditMunicipality", function (e){
    e.preventDefault();
    const id=localStorage.getItem("id_municipality")
    const jsonData={
        codigo:$("#floatingCodigoUpdate").val(),
        descripcion: $("#floatingDescripcionUpdate").val(),
        departamento_id:$("#idDepart :selected").val()
    }
    localStorage.removeItem('idDepartament');
    console.log(jsonData)
    updateMunicipality(id, jsonData)
});

$(document).on("click",".deleteMunicipality", function (e){

    localStorage.setItem("id_municipality",$(this).data("id"));
})

$(document).on("click","#btnDeletemunicipality", function (e){
    
    e.preventDefault();
    const id=localStorage.getItem("id_municipality")
    localStorage.removeItem('id_municipality');
    deleteMunicipality(id)
});
