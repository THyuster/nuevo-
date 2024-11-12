<!-- Creación de empresa - modal-->
<div id="createCompany" class="modal fade" tabindex="-1" aria-labelledby="createCompanyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formularioCrear" action="">
                <div class="modal-header">
                    <h4>Creación de empresa</h4>
                </div>
                <div class="modal-body">
                    <form id="formularioCrear" action="">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nit" name="nit" required>
                            <label for="nit">Nit</label>
                            <p id="mensaje_error"></p>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="tercero" name="tercero" required>
                            <label for="tercero">Tercero</label>
                            <p id="mensaje_error"></p>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" list="datalistCliente" id="cliente" name="cliente_id"
                                placeholder="cliente_id">
                            <datalist id="datalistCliente">
                                @foreach ($companieGroups as $companieGroup)
                                    <option value="{{ $companieGroup->id }} - {{ $companieGroup->descripcion }}">
                                @endforeach
                            </datalist>
                            <label for="cliente_id">Grupo empresarial y/o cliente</label>
                        </div>
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control" id="razon_social" name="razon_social" required>
                            <label for="razon_social">Razón social</label>
                        </div>
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                            <label for="direccion">Dirección</label>
                        </div>
                        <div class="form-floating mb-1">
                            <input type="text" class="form-control" id="telefono" name="telefono" required
                                maxlength="10" pattern="\d+" title="ingrese solo numeros">
                            <label for="telefono">Telefonos</label>
                        </div>

                        <div class="form-floating mb-1">
                            <input type="text" class="form-control" id="email" name="email" required>
                            <label for="email">Correo electrónico</label>
                            <p id="mensaje_error"></p>
                        </div>
                        <div class="form-floating mb-1">
                            <input type="file" class="form-control" id="ruta_imagen" name="ruta_imagen" required>
                            <label for="ruta_imagen">ruta imagen</label>
                        </div>

                </div>
                <div class="modal-footer">
                    <button id="btnCreateCompany" class="btn btn-primary" type="submit">Crear</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal de edición de empresas -->
<div id="editCompany" class="modal fade" tabindex="-1" aria-labelledby="editCompanyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>edición de empresa</h4>
            </div>
            <div class="modal-body">
                <form id="formularioActualizar" action="">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nit" name="nit" required>
                        <label for="nit">Nit</label>
                        <p id="mensaje_error"></p>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="tercero" name="tercero" required>
                        <label for="tercero">Tercero</label>
                        <p id="mensaje_error"></p>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" list="datalistCliente" id="cliente" name="cliente_id"
                            placeholder="cliente_id">
                        <datalist id="datalistCliente">
                            @foreach ($companieGroups as $companieGroup)
                                <option value="{{ $companieGroup->id }} - {{ $companieGroup->descripcion }}">
                            @endforeach
                        </datalist>
                        <label for="cliente_id">Grupo empresarial y/o cliente</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="razon_social" name="razon_social" required>
                        <label for="razon_social">Razón social</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                        <label for="direccion">Dirección</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="number" class="form-control" id="telefono" name="telefono" required
                            maxlength="10" pattern="\d+" title="ingrese solo numeros">
                        <label for="telefono">Telefonos</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="email" name="email" required>
                        <label for="email">Correo electrónico</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="file" class="form-control" id="ruta_imagen" name="ruta_imagen" required>
                        <label for="ruta_imagen">ruta imagen</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnEditCompany" class="btn btn-primary" type="submit">Actualizar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de eliminación de empresas -->
<div id="deleteCompany" class="modal fade" tabindex="-1" aria-labelledby="deleteCompanyLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar la empresa?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteCompany" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>
