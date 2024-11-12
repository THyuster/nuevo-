<div class="modal fade " id="createMainAdmin" tabindex="-1" aria-labelledby="createMainAdminLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-md ">
        <div class="modal-content">
            <form id="formCreateMainAdmin">
                <div class="modal-header ">
                    <h4 class="modal-title ml-1" >Nuevo Administrador</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="name" name="name" required>
                        <label for="name">nombre</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="email" name="email" required>
                        <label for="email">correo electrónico</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <label for="password">contraseña</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="cliente_id"
                            name="cliente_id" aria-label="Grupo empresarial"
                            required>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->descripcion }}</option>
                            @endforeach
                        </select>
                        <label for="cliente_id"><strong>Grupo empresarial</strong></label>
                    </div>                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnCreateMainAdmin" type="submit" form="formCreateMainAdmin" class="btn btn-primary">confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editMainAdmin" tabindex="-1" aria-labelledby="editMainAdminLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-md ">
        <div class="modal-content">
            <form id="formEditMainAdmin">
                <div class="modal-header ">
                    <h4 class="modal-title ml-1">Actualizar administrador</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="name" name="name" required>
                        <label for="name">nombre</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="email" name="email" required>
                        <label for="email">correo electrónico</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <label for="password">contraseña</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="cliente_id"
                            name="cliente_id" aria-label="Grupo empresarial"
                            required>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->descripcion }}</option>
                            @endforeach
                        </select>
                        <label for="cliente_id"><strong>Grupo empresarial</strong></label>
                    </div>                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnEditMainAdmin" type="submit" form="formEditMainAdmin" class="btn btn-primary">confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="deleteMainAdmin" class="modal fade" tabindex="-1" aria-labelledby="deleteMainAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el administrador?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteMainAdmin" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>