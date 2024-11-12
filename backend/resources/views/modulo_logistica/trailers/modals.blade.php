{{--modal de elminación--}}
<div id="eliminarTrailer" class="modal fade" tabindex="-1" aria-labelledby="createMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el grupo de vehiculo?</p>
            </div>
            <div class="modal-footer">
                <button id="btnEliminarTrailer" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

{{--modal de creación--}}
<div class="modal fade" id="crearTrailer" tabindex="-1" aria-labelledby="crearTrailerLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModulesLabel">Crear Trailer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="modal-body form-group">
                    <form onsubmit="return false;" id="formularioCrear">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="codigo" name="codigo"
                                placeholder="Orden">
                            <label for="codigo">codigo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="descripcion" name="descripcion"
                                placeholder="descripcion">
                            <label for="descripcion">Descripción</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btnCrearTrailer" class="btn btn-success" tabindex="4">Confirmar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                        tabindex="5">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{--modal de edición--}}
<div class="modal fade " id="actualizarTrailer" tabindex="-1" aria-labelledby="actualizarTrailerLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarMenuLabel">Editar Grupo de Vehiculo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-group">
                <form onsubmit="return false;" id="formularioActualizar">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="codigo" name="codigo"
                            placeholder="Descripcion">
                        <label for="codigo">Codigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="descripcion" name="descripcion"
                            placeholder="descripcion">
                        <label for="descripcion">Descripción</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnActualizarTrailer" class="btn btn-success" tabindex="4">Confirmar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                    tabindex="5">Cancelar</button>
            </div>
        </div>
    </div>
</div>