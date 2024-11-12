{{--modal de eliminación departamento--}}
<div id="deleteModalBranch" class="modal fade" tabindex="-1" aria-labelledby="createMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro/a que desea eliminar el departamento?</p>
            </div>
            <div class="modal-footer">
                <button id="deleteConfirmButton" class="btn btn-primary delete" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>
{{--modal de creación--}}
<div class="modal fade " id="createBranch" tabindex="-1" aria-labelledby="createModulesLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModulesLabel">Crear Nueva sucursal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formPermisosCrear shadow">
                <div class="container">
                    <div class="modal-body form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control"  id="floatingCodigo"
                                placeholder="Codigo">
                            <label for="floatingCodigo">Codigo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control"  id="floatingDescripcion"
                                placeholder="Descripcion">
                            <label for="floatingDepartament">Descripcion</label>
                        </div>
                        <div class="form-group">
                        <label for="sucursal" class="form-label">Municipio:</label>
                        <select id="idSucursal" name="sucursal" class="form-select" required>
                            @foreach ($municipalitys as $municipality)
                            <option value="{{ $municipality->id}}">{{$municipality->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                        
                    </div>
                    <div class="modal-footer">
                        <a id="btnCreateBranch" class="btn btn-success" tabindex="4">Crear</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            class="btn btn-secondary" tabindex="5">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{{--modal de edición--}}
<div class="modal fade " id="editBranch" tabindex="-1" aria-labelledby="editModulesLabel" aria-hidden="true">
    <form id="formPermisosEditar">
        <div class="modal-dialog  modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModulesLabel">Editar sucursal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body form-group">
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control"  id="floatingCodigoUpdate"
                            placeholder="Codigo">
                        <label for="floatingCodigo">Codigo</label>
                    </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control"  id="floatingDescripcionUpdate"
                                placeholder="Descripcion">
                            <label for="floatingBranch">Descripcion</label>
                        </div>
                        <select id="idSucursal" name="sucursal" class="form-select" required>
                            @foreach ($municipalitys as $municipality)
                            <option value="{{ $municipality->id}}">{{$municipality->descripcion}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="modal-footer">
                    <a id="btnEditBranch" class="btn btn-success" tabindex="4">Confirmar</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    class="btn btn-secondary" tabindex="5">Cancelar</button>
                </div>

            </div>
        </div>
    </form>
</div>