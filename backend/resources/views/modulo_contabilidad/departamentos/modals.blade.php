{{--modal de eliminación departamento--}}
<div id="deleteModalDept" class="modal fade" tabindex="-1" aria-labelledby="createMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro/a que desea eliminar el departamento?</p>
            </div>
            <div class="modal-footer">
                <button id="deleteConfirmButton" class="btn btn-primary delete" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>
{{--modal de creación--}}
<div class="modal fade " id="createDept" tabindex="-1" aria-labelledby="createModulesLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModulesLabel">Crear Nuevo Departamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="modal-body form-group">
                    <form id="formPermisosCrear shadow">
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" id="floatingDescripcion"
                                placeholder="Codigo">
                            <label for="floatingDescripcion">Codigo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" id="floatingDepartament"
                                placeholder="Departamento">
                            <label for="floatingDepartament">Departamento</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a id="btnCreateDept" class="btn btn-success" tabindex="4">Crear</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                        tabindex="5">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{--modal de edición--}}
<div class="modal fade " id="editDept" tabindex="-1" aria-labelledby="editModulesLabel" aria-hidden="true">
    <form id="formPermisosEditar">
        <div class="modal-dialog  modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModulesLabel">Editar Departamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body form-group">
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="floatingCodigoUpdate"
                            placeholder="Codigo">
                        <label for="floatingDescripcionUpdate">Codigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="floatingDescripcionUpdate"
                            placeholder="Descripcion">
                        <label for="floatingUbicacionUpdate">Descripcion</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <a id="btnEditDept" class="btn btn-success" tabindex="4">Confirmar</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                        tabindex="5">Cancelar</button>
                </div>

            </div>
        </div>
    </form>
</div>