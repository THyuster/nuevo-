{{--modal de elminación--}}
<div id="deleteCentroTrabajo" class="modal fade" tabindex="-1" aria-labelledby="createCentroTrabajoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el Centro de trabajo?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteCentroTrabajo" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

{{--modal de creación--}}
<div class="modal fade " id="createCentroTrabajo" tabindex="-1" aria-labelledby="createCentroTrabajoLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModulesLabel">Crear Nuevo Centro de trabajo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="modal-body form-group">
                    <form onsubmit="return false;" id="FormCrearCentroTrabajo">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="codigo" id="codigo" placeholder="codigo">
                            <label for="codigo">codigo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="descripcion">
                            <label for="descripcion">Descripción</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnCreateCentroTrabajo" class="btn btn-success" tabindex="4">Confirmar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary" tabindex="5">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{--modal de edición--}}
<div class="modal fade " id="editCentroTrabajo" tabindex="-1" aria-labelledby="editCentroTrabajo" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarMenuLabel">Editar Centro de trabajo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-group">
                <form onsubmit="return false;" id="FormActualizarCentroTrabajo">
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" name="codigo" id="codigo" placeholder="codigo">
                        <label for="codigo">Codigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" name="descripcion" id="descripcion" placeholder="descripcion">
                        <label for="descripcion">Descripción</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnEditCentroTrabajo" class="btn btn-success" tabindex="4">Confirmar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary" tabindex="5">Cancelar</button>
            </div>
        </div>
    </div>
</div>