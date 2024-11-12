{{--modal de creación de tipo de orden--}}
<div class="modal fade " id="createTypeOrder" tabindex="-1" aria-labelledby="createTypeOrderLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <form id="formCreateTypeOrder">
                <div class="modal-header ">
                    <h4 class="modal-title ml-1" >Nuevo tipo de orden</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="codigo" name="codigo" id="codigo">
                        <label for="codigo">Codigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class=" form-control"  id="descripcion"
                            placeholder="descripcion" name="descripcion">
                        <label for="descripcion">Descripcion</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class=" form-control" id="tipo_acta_modal" placeholder="tipo_acta_modal" name="tipo_acta_modal">
                        <label for="tipo_acta_modal">Tipo de acta modal</label>
                    </div>
                    </div>
                <div class="modal-footer">
                    <button id="btnCreateTypeOrder" class="btn btn-success" tabindex="4">Crear</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        class="btn btn-secondary" tabindex="5">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--modal de edición de tipo de orden--}}
<div class="modal fade " id="updateTypeOrder" tabindex="-1" aria-labelledby="updateTypeOrderLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-xl ">
        <div class="modal-content">
            <form id="formUpdateTypeOrder">
                <div class="modal-header ">
                    <h4 class="modal-title ml-1" >Editar asignación técnica</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="codigo" name="codigo" id="codigo">
                        <label for="codigo">Codigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class=" form-control"  id="descripcion"
                            placeholder="descripcion" name="descripcion">
                        <label for="descripcion">Descripcion</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class=" form-control" id="tipo_acta_modal" placeholder="tipo_acta_modal" name="tipo_acta_modal">
                        <label for="tipo_acta_modal">Tipo de acta modal</label>
                    </div>
                    </div>
                <div class="modal-footer">
                    <a id="btnUpdateTypeOrder" class="btn btn-success" tabindex="4">Confirmar</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary" tabindex="5">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal de eliminación tipo de orden --}}
<div id="deleteTypeOrder" class="modal fade" tabindex="-1" aria-labelledby="deleteTypeOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro/a que desea eliminar el tipo de orden?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteTypeOrder" class="btn btn-danger delete" type="submit">Confirmar</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>