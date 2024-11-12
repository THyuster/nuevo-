{{--modal de eliminación departamento--}}
<div id="ID_TypeDelete" class="modal fade" tabindex="-1" aria-labelledby="ID_TypeDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro/a que desea eliminar el tipo de identificación</p>
            </div>
            <div class="modal-footer">
                <button id="ID_TypeDeleteBtn" class="btn btn-primary delete" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>
{{--modal de creación--}}
<div class="modal fade " id="ID_TypeCreate" tabindex="-1" aria-labelledby="ID_TypeCreateLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModulesLabel">Crear Nuevo tipo de identificacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="modal-body form-group">
                    <form id="formPermisosCrear">
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" id="floatingCodigo" placeholder="Codigo">
                            <label for="floatingCodigo">Codigo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" id="floatingDescripcion"
                                placeholder="Descripcion">
                            <label for="floatingDepartament">Descripcion</label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a id="ID_TypeCreateBtn" class="btn btn-success" tabindex="4">Crear</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                    tabindex="5">Cancelar</button>
            </div>
        </div>
    </div>
</div>
</div>
{{--modal de edición--}}
<div class="modal fade " id="ID_TypeEdit" tabindex="-1" aria-labelledby="ID_TypeEditLabel" aria-hidden="true">
    <form id="formPermisosEditar">
        <div class="modal-dialog  modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModulesLabel">Editar tipo de tercero</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body form-group">
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" id="floatingCodigoUpdate"
                            placeholder="Codigo">
                        <label for="floatingCodigo">Codigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" id="floatingDescripcionUpdate"
                            placeholder="Descripcion">
                        <label for="floatingBranch">Descripcion</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="ID_TypeEditBtn" class="btn btn-success" tabindex="4">Confirmar</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                        tabindex="5">Cancelar</button>
                </div>
            </div>
        </div>
    </form>
</div>