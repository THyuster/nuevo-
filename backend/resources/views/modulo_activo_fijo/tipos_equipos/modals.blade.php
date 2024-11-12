{{--modal de elminación--}}
<div id="deleteActivosFijosTiposEquipo" class="modal fade" tabindex="-1" aria-labelledby="createMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el tipo de equipo?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteActivosFijosTiposEquipo" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

{{--modal de creación--}}
<div class="modal fade " id="createActivosFijosTiposEquipo" tabindex="-1" aria-labelledby="createArticlesTypeLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModulesLabel">Crear Nuevo tipo de equipo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="modal-body form-group">
                    <form onsubmit="return false;" id="formPermisosCrear">
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" value="" id="floatingCodigo"
                                placeholder="Orden">
                            <label for="floatingCodigo">codigo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" value="" id="floatingDescripcion"
                                placeholder="Descripcion">
                            <label for="floatingDescripcion">Descripción</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnCreateActivosFijosTiposEquipo" class="btn btn-success" tabindex="4">Confirmar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                        tabindex="5">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{--modal de edición--}}
<div class="modal fade " id="editActivosFijosTiposEquipo" tabindex="-1" aria-labelledby="editArticleTypeLabel" aria-hidden="true">
    <form onsubmit="return false;" id="formPermisosEditar">
        <div class="modal-dialog  modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarMenuLabel">Editar Tipo de equipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body form-group">
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="floatingCodigoUpdate"
                            placeholder="Descripcion">
                        <label for="floatingCodigoUpdate">Codigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="floatingDescripcionUpdate"
                            placeholder="Descripcion">
                        <label for="floatingDescripcionUpdate">Descripción</label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button id="btnEditActivosFijosTiposEquipo" class="btn btn-success" tabindex="4">Confirmar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                        tabindex="5">Cancelar</button>
                </div>

            </div>
        </div>
    </form>
</div>