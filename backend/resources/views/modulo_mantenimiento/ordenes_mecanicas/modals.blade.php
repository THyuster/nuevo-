
{{--modal de creación--}}
<div class="modal fade " id="createMechanicalOrder" tabindex="-1" aria-labelledby="createMechanicalOrderLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-md ">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title">Nuevo tipo de solicitud</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-group">
                <form id="formCreateMechanicalOrder">
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control"  id="floatingCodigo" 
                            placeholder="Codigo" name="codigo">
                        <label for="floatingCodigo">Codigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control"  id="floatingDescripcion"
                            placeholder="Descripcion" name="descripcion">
                        <label for="floatingDepartament">Descripcion</label>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                    <a id="btnCreateMechanicalOrder" class="btn btn-success" tabindex="4">Crear</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        class="btn btn-secondary" tabindex="5">Cancelar</button>
            </div>
        </div>
    </div>
</div>

{{--modal de edición--}}
<div class="modal fade " id="updateMechanicalOrder" tabindex="-1" aria-labelledby="updateMechanicalOrderLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-md ">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar tipo de Solicitud</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body form-group">
                    <form id="formUpdateMechanicalOrder">
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control"  id="codigo"
                            placeholder="codigo"  name="codigo">
                        <label for="codigo">Codigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control"  id="descripcion"
                            placeholder="descripcion" name="descripcion">
                        <label for="descripcion">Descripcion</label>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <a id="btnUpdateMechanicalOrder" class="btn btn-success" tabindex="4">Actualizar</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        class="btn btn-secondary" tabindex="5">Cancelar</button>
                </div>
        </div>
    </div>
</div>

{{-- modal de eliminación departamento --}}
<div id="deleteMechanicalOrder" class="modal fade" tabindex="-1" aria-labelledby="deleteMechanicalOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro/a que desea eliminar la orden?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteMechanicalOrder" class="btn btn-primary delete" type="submit">Confirmar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>