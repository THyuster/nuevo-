<!-- Creación de prefijo - modal-->
<div id="createPrefix" class="modal fade" tabindex="-1" aria-labelledby="createPrefixLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Creación de prefijo</h4>
            </div>
            <div class="modal-body">
                <form id="formularioCrear" action="">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="codigo"
                            name="codigo" required>
                        <label for="codigo">Codigo Nuevo prefijo</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="descripcion"
                            name="descripcion" required>
                        <label for="descripcion">nombre del prefijo</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCreatePrefix" class="btn btn-primary" type="submit">Crear</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--Modal de edición de prefijos -->
<div id="editPrefix" class="modal fade" tabindex="-1" aria-labelledby="editPrefixLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>edición de prefijo</h4>
            </div>
            <div class="modal-body">
                <form id="formularioActualizar" action="">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="codigo"
                            name="codigo" required>
                        <label for="codigo">editar código del Prefijo</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="descripcion"
                            name="descripcion" required>
                        <label for="descripcion">editar nombre del prefijo</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnEditPrefix" class="btn btn-primary" type="submit">Actualizar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de eliminación de prefijos -->
<div id="deletePrefix" class="modal fade" tabindex="-1" aria-labelledby="deletePrefixLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el prefijo?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeletePrefix" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

