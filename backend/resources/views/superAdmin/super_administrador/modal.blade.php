<div class="modal fade " id="createSuperSU" tabindex="-1" aria-labelledby="createSuperSULabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title ml-1">ASIGNAR SUADMIN</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form onsubmit="return false;" id="form_su_admin">
                    <div class="form-floating mb-3">
                        <input type="text"  class="form-control" name="nombre" id="nombre"
                            placeholder="nombre" autocomplete="off" required>
                        <label for="nombre">nombre</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="Email" autocomplete="off" required>
                        <label for="Email">Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Contraseña" autocomplete="off" required>
                        <label for="password">Contraseña</label>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button"  class="btn btn-secondary " data-bs-dismiss="modal">Cancelar</button>
                <button id="btnAsignarSu" type="submit" class="btn btn-primary">Guardar</button>
            </div>
            
        </div>
    </div>
</div>

<div id="deleteSuperSU" class="modal fade" tabindex="-1" aria-labelledby="deleteLicenseLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar la licencia?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteSuperSU" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>
