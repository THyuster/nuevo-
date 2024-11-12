{{--modal de eliminación--}}
<div id="deleteSubmenuModal" class="modal fade" tabindex="-1" aria-labelledby="createMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el submenu?</p>
            </div>
            <div class="modal-footer">
                <button id="DeleteSubmenu" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>
{{--modal de creación--}}
<div class="modal fade " id="CreateSubmenu" tabindex="-1" aria-labelledby="createModulesLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModulesLabel">Crear Nueva bodega</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formPermisosCrear shadow">
                <div class="container">
                    <div class="modal-body form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" value="test" id="floatingDescripcion"
                                placeholder="Descripcion">
                            <label for="floatingDescripcion">Descripcion</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" value="1" id="floatingOrden"
                                placeholder="Orden">
                            <label for="floatingOrden">Orden</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a  id="btnCreateSubmenu" class="btn btn-success" href="#AsignarPermiso"
                            tabindex="4" >Confirmar</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            class="btn btn-secondary" tabindex="5">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{--modal de edición--}}
<div class="modal fade " id="editSubmenu" tabindex="-1" aria-labelledby="editarModulesLabel" aria-hidden="true">
    <form id="formPermisosEditar">
        <div class="modal-dialog  modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModulesLabel">Editar submenu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body form-group">
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="floatingDescripcionUpdate"
                            placeholder="Descripcion">
                        <label for="floatingDescripcionUpdate">Descripcion</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="floatingOrdenUpdate"
                            placeholder="Orden">
                        <label for="floatingOrdenUpdate">Orden</label>
                    </div> 
                </div>

                <div class="modal-footer">
                    <a id="btneditSubmenu" class="btn btn-success" href="#editardiseno" tabindex="4">confirmar</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    class="btn btn-secondary" tabindex="5">Cancelar</button>
                </div>

            </div>
        </div>
    </form>
</div>