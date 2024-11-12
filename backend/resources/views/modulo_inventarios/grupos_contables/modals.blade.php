{{--modal de elminación--}}
<div id="deleteGrupoContable" class="modal fade" tabindex="-1" aria-labelledby="createMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el grupo de articulos?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteGrupoContable" class="btn btn-primary" tabindex="4">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

{{--modal de creación--}}
<div class="modal fade " id="createGrupoContable" tabindex="-1" aria-labelledby="creategroupArticlesLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModulesLabel">Crear Nuevo Contable</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <form onsubmit="return false;" id="formPermisosCrear">
                    <div class="modal-body form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="  form-control" value="" id="floatingCodigo"
                                placeholder="Orden">
                            <label for="floatingCodigo">Codigo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="  form-control" value="" id="floatingDescripcion"
                                placeholder="Descripcion">
                            <label for="floatingDescripcion">Descripción</label>
                        </div>

                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCreateGrupoContable" class="btn btn-success" type="submit"
                    tabindex="4">Confirmar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                    tabindex="5">Cancelar</button>
            </div>
        </div>
    </div>
</div>
</div>

{{--modal de edición--}}
<div class="modal fade " id="editGrupoContable" tabindex="-1" aria-labelledby="editGroupArticlesLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarMenuLabel">Editar grupo de artículos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-group">
                <form onsubmit="return false;" id="formPermisosEditar">
                    <div class="form-floating mb-3">
                        <input type="text" class="  form-control" value="" id="floatingCodigoUpdate"
                            placeholder="Descripcion">
                        <label for="floatingCodigoUpdate">codigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="  form-control" value="" id="floatingDescripcionUpdate"
                            placeholder="Descripcion">
                        <label for="floatingDescripcionUpdate">Descripcion</label>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button id="btnEditGrupoContable" class="btn btn-success" tabindex="4">Confirmar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                    tabindex="5">Cancelar</button>
            </div>

        </div>
    </div>
</div>