{{--modal de elminación--}}
<div id="deleteArticle" class="modal fade" tabindex="-1" aria-labelledby="createMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar la bodega?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteArticle" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

{{--modal de creación--}}
<div class="modal fade " id="createArticle" tabindex="-1" aria-labelledby="createArticleLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModulesLabel">Crear Nuevo Articulo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form onsubmit="return false;" id="formPermisosCrear">
                <div class="container">
                    <div class="modal-body form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="  form-control" value="" id="floatingCodigo"
                                placeholder="Orden">
                            <label for="floatingCodigo">codigo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="  form-control" value="" id="floatingDescripcion"
                                placeholder="Descripcion">
                            <label for="floatingDescripcion">Descripción</label>
                        </div>

                        <div class="form-group">
                            <label for="idSucursal" class="form-label">Sucursal:</label>
                            <select id="idSucursal" name="idSucursal" class="form-select" required>
                                <option value="0" selected>Seleccione</option>

                            </select>
                        </div>

                    </div>
            </form>
            <div class="modal-footer">
                <button id="btnCreateArticle" class="btn btn-success" tabindex="4">Confirmar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                    tabindex="5">Cancelar</button>
            </div>
        </div>
    </div>
</div>
</div>

{{--modal de edición--}}
<div class="modal fade " id="editArticle" tabindex="-1" aria-labelledby="editarMenuLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarMenuLabel">Editar Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form onsubmit="return false;" id="formPermisosEditar">
                <div class="modal-body form-group">
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

                    <div class="form-group">
                        <label for="idSucursalUpdate" class="form-label">Sucursal:</label>
                        <select id="idSucursalUpdate" name="idSucursalUpdate" class="form-select" required>
                            <option value="0" selected>Seleccione</option>

                        </select>
                    </div>
                </div>
            </form>

            <div class="modal-footer">
                <button id="btnEditArticle" type="submit" class="btn btn-success" tabindex="4">Confirmar</button>
                <button id="" type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    class="btn btn-secondary" tabindex="5">Cancelar</button>
            </div>

        </div>
    </div>
</div>