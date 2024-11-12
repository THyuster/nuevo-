{{--modal de eliminación municipio--}}
<div id="deleteMunicipality" class="modal fade" tabindex="-1" aria-labelledby="deleteMunicipalityLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro/a que desea eliminar el municipio?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeletemunicipality" class="btn btn-primary delete" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>
{{--modal de creación--}}
<div class="modal fade " id="createMunicipality" tabindex="-1" aria-labelledby="createMunicipalityLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModulesLabel">Crear Nuevo municipio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="modal-body form-group">
                    <form id="formPermisosCrear">
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" id="floatingDescripcion"
                                placeholder="Codigo">
                            <label for="floatingDescripcion">Codigo</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" id="floatingDepartament"
                                placeholder="Municipio">
                            <label for="floatingDepartament">Municipio</label>
                        </div>
                        <label for="departament" class="form-label">Departamento</label>
                        <select id="idDepartament" name="sucursal" class="form-select" required>
                            <option value="0">Seleccione</option>
                            @foreach ($departaments as $departament)
                            <option value="{{ $departament->id}}">{{$departament->descripcion}}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <a id="btnCreateMunicipality" class="btn btn-success" tabindex="4">Crear</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                        tabindex="5">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{--modal de edición--}}
<div class="modal fade " id="editMunicipality" tabindex="-1" aria-labelledby="editModulesLabel" aria-hidden="true">
    <form id="formPermisosEditar">
        <div class="modal-dialog  modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModulesLabel">Editar Municipio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body form-group">
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="floatingCodigoUpdate"
                            placeholder="Codigo">
                        <label for="floatingDescripcionUpdate">Codigo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="floatingDescripcionUpdate"
                            placeholder="Descripcion">
                        <label for="floatingUbicacionUpdate">Descripcion</label>
                    </div>
                    <label for="departament" class="form-label">Departamento:</label>
                    <select id="idDepart" name="departament" class="form-select" required>
                        @foreach ($departaments as $departament)
                        <option value="{{ $departament->id}}">{{$departament->descripcion}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <a id="btnEditMunicipality" class="btn btn-success" tabindex="4">Confirmar</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                        tabindex="5">Cancelar</button>
                </div>

            </div>
        </div>
    </form>
</div>