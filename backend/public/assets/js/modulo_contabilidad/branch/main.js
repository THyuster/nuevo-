
$(document).on("click","#btnCreateBranch",function(e){

    e.preventDefault();
    
    const jsonData={
        municipio_id:$("#idSucursal :selected").val(),
        codigo:$("#floatingCodigo").val(),
        descripcion: $("#floatingDescripcion").val()
    }
    
    createBranch(jsonData)
});

$(document).on("click",".editFormModule", function (e){
    e.preventDefault();
    $("#idSucursal").val($(this).data("munid"));

    localStorage.setItem("id_Branch", $(this).data("id"));
    $("#floatingCodigoUpdate").val($(this).data("codigo"));
    $("#floatingDescripcionUpdate").val($(this).data("descripcion"));
});

$(document).on("click","#btnEditBranch", function (e){
    e.preventDefault();
    const id=localStorage.getItem("id_Branch")
    const jsonData={
        municipio_id:$("#idSucursal :selected").val(),
        codigo:$("#floatingCodigoUpdate").val(),
        descripcion: $("#floatingDescripcionUpdate").val()
    }
    localStorage.removeItem('id_Branch');
    updateBranch(id, jsonData)
});

$(document).on("click",".deleteBranch", function (e){
    localStorage.setItem("id_branch",$(this).data("id"));
})

$(document).on("click","#deleteModalBranch", function (e){
    e.preventDefault();
    const id=localStorage.getItem("id_branch")
    localStorage.removeItem('id_branch');
    deleteBranch(id)
});

$(document).on("click","#btnStatusChangeMenu", function (e){
    e.preventDefault();
    updateStatus( $(this).data("id"));
});