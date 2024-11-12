{{-- modal de eliminación --}}
<div id="deleteConfirmationModal" class="modal fade" tabindex="-1" aria-labelledby="createMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro/a que desea eliminar el modulo?</p>
            </div>
            <div class="modal-footer">
                <button id="deleteConfirmButton" class="btn btn-primary delete" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>
{{-- modal de creación --}}
<div class="modal fade " id="createModules" tabindex="-1" aria-labelledby="createModulesLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModulesLabel">Crear Nuevo Módulo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formPermisosCrear">
                <!-- <div class="container"> -->
                    <div class="modal-body form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" name="codigo" value="M32" id="codigo"
                                placeholder="Descripcion">
                            <label for="codigo">Codigo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" name="descripcion" value="test" id="descripcion"
                                placeholder="Descripcion">
                            <label for="descripcion">Descripción</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="ruta" class="rounded-0 form-control" value="test_vista1"
                                id="ruta" placeholder="Ruta">
                            <label for="ruta">ruta</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" name="orden" value="1" id="orden"
                                placeholder="orden">
                            <label for="orden">Orden</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="file" class="rounded-0 form-control" name="ruta_imagen"  id="ruta_imagen"
                                placeholder="ruta_imagen">
                            <label for="orden">Logo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select id="tipo_acceso" name="tipo_acceso" aria-label="TipoUsuario" class="form-select  mb-3">
                                @foreach ($tiposAdministrador as $item)
                                    <option value="{{ $item->id }}">{{ $item->tipo_administrador }}</option>
                                @endforeach
                            </select>
                            <label for="tipo_acceso">Tipo de usuario</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a id="btnCreateModule" class="btn btn-success" tabindex="4">Confirmar</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            class="btn btn-secondary" tabindex="5">Cancelar</button>
                    </div>
                <!-- </div> -->
            </form>
        </div>
    </div>
</div>
{{-- modal de edición --}}
<div class="modal fade " id="editModules" tabindex="-1" aria-labelledby="editModulesLabel" aria-hidden="true">
    <form id="formPermisosEditar">
        <div class="modal-dialog  ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModulesLabel">Editar Módulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body form-group">
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value=""
                            id="descripcion" name="descripcion" placeholder="Descripcion">
                        <label for="descripcion">Descripción</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="ubicacion" name="ubicacion"
                            placeholder="Ruta">
                        <label for="ubicacion">Ubicación</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="orden" name="orden"
                            placeholder="Orden">
                        <label for="orden">Orden</label>
                    </div>

                    <div class="form-floating mb-3">
                            <input type="file" class="rounded-0 form-control" name="ruta_imagen"  id="ruta_imagen"
                                placeholder="logo">
                            <label for="ruta_imagen">Logo</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select id="tipo_usuario" aria-label="floatingTipoUsuarioUpdate"
                            class="form-select  mb-3" name="tipo_usuario">
                            @foreach ($tiposAdministrador as $item)
                                <option value="{{ $item->id }}">{{ $item->tipo_administrador }}</option>
                            @endforeach
                        </select>
                        <label for="tipo_usuario">Tipo de usuario</label>
                    </div>

                    <div><img src="" alt="image_upload"></div>
                </div>

                <div class="modal-footer">
                    <a id="btnEditModules" class="btn btn-success" tabindex="4">Confirmar</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        class="btn btn-secondary" tabindex="5">Cancelar</button>
                </div>

            </div>
        </div>
    </form>
</div>
