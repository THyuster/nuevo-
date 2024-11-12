{{-- modal formulario creación--}}
<div id="createTypeReceipt" class="modal fade" tabindex="-1" aria-labelledby="createTypeReceiptLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">          
            <div class="modal-header">
                <h4>Creación de tipo de comprobante</h4>
            </div>
            <div class="modal-body form-group">
                <form id="createTypeReceiptForm" >
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="codigo"  id="codigo" placeholder="Codigo">
                        <label for="Codigo">Codigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="descripcion">
                        <label for="descripcion">descripción</label>
                    </div>
                    <div class="form-floating mb-1">
                        <select class="form-select  mb-1" aria-label="signoLabel" id="signo" name="signo">
                            <option value="1">1</option>
                            <option value="-1">-1</option>
                        </select>
                        <label for="signo">Signo</label>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
            <button class="btn btn-primary" type="submit" id="btnCreateTypeReceipt">Confirmar</button>
            <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="close">Cancelar</button>
            </div>
        </div>
    </div>
</div>
{{-- modal formulario edición--}}
<div id="updateTypeReceipt" class="modal fade" tabindex="-1" aria-labelledby="updateTypeReceiptLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edición de tipo de comprobante</h4>
            </div>
            <div class="modal-body form-group">
                <form id="updateTypeReceiptForm" >
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="codigo" id="codigo" placeholder="codigo">
                        <label for="Codigo">Codigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="descripcion">
                        <label for="descripcion">descripción</label>
                    </div>
                    <div class="form-floating mb-1">
                        <select class="form-select  mb-1" aria-label="signoLabel" id="signo" name="signo">
                            <option value="1">1</option>
                            <option value="-1">-1</option>
                        </select>
                        <label for="signo">Signo</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            <button class="btn btn-primary" type="submit" id="btnUpdateTypeReceipt">Confirmar</button>
            <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

{{--modal de eliminación--}}
<div id="deleteTypeReceipt" class="modal fade" tabindex="-1" aria-labelledby="deleteTypeReceiptLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el tipo de comprobante?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeletetypeReceipt" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>