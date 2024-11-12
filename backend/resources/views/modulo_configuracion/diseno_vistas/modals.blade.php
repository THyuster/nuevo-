{{--modal de eliminación id:deleteView--}}
<div id="deleteConfirmationModal" class="modal fade" tabindex="-1" aria-labelledby="createMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar la vista?</p>
            </div>
            <div class="modal-footer">
                <button id="deleteView" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>
{{--modal de creación id: btnCreateView--}}
<div class="modal fade " id="createView" tabindex="-1" aria-labelledby="createModulesLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModulesLabel">Crear Nueva vista</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formPermisosCrear shadow">
                <div class="container">
                    <div class="modal-body form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" value="" id="floatingDescripcion"
                                placeholder="Descripcion">
                            <label for="floatingDescripcion">Descripcion</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control"  value="" id="floatingUbicacion"
                                placeholder="Ruta">
                            <label for="floatingUbicacion">Ruta</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control"  value="" id="floatingOrden"
                                placeholder="Ruta">
                            <label for="floatingOrden">Orden</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a id="btnCreateView" class="btn btn-success" href="#AsignarPermiso"
                            tabindex="4"><i class="fa-solid fa-plus">CREAR</i></a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            class="btn btn-secondary" tabindex="5">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{--modal de edición id:btnEditView--}}
<div class="modal fade " id="editView" tabindex="-1" aria-labelledby="editarModulesLabel" aria-hidden="true">
    <form id="formPermisosEditar">
        <div class="modal-dialog  modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModulesLabel">Crear Nuevo Módulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body form-group">
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="test update" id="floatingDescripcionUpdate"
                            placeholder="Descripcion">
                        <label for="floatingDescripcionUpdate">Descripcion</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="ruta update" id="floatingUbicacionUpdate"
                            placeholder="Ruta">
                        <label for="floatingUbicacionUpdate">Ubicacion</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="orden update" id="floatingOrdenUpdate"
                            placeholder="Orden">
                        <label for="floatingOrdenUpdate">Orden</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <a id="btnEditView" class="btn btn-success" href="#editardiseno" tabindex="4">Confirmar</a>
                </div>

            </div>
        </div>
    </form>
</div>