<div class="modal fade " id="createLicense" tabindex="-1" aria-labelledby="createLicenseLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-md ">
        <div class="modal-content">
            <form id="formCreatelicense">
                <div class="modal-header ">
                    <h4 class="modal-title ml-1">Nueva licencia</h4>
                    <div class="form-floating mx-5">
                        <select name="cliente_id" class="form-select" id="cliente_id" name="cliente_id"
                            aria-label="cliente_id" autocomplete="off">
                            <option value="0"> Seleccione</option>
                            @foreach ($group as $companyGroup)
                                <option value="{{ $companyGroup->id }}">{{ $companyGroup->descripcion }}</option>
                            @endforeach
                        </select>
                        <label for="cliente_id">grupo empresarial</label>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="empresa_id" list="datalistEmpresa_id"
                            placeholder="empresa_id" name="empresa_id" autocomplete="off">
                        <datalist id="datalistEmpresa_id">
                        </datalist>
                        <label for="empresa">empresa</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="codigo" placeholder="codigo" name="codigo">
                        <label for="codigo">codigo</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="descripcion" placeholder="descripcion"
                            name="descripcion">
                        <label for="descripcion">Descripción licencia</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="cantidad_users" placeholder="cantidadLicencias"
                            name="cantidad_users">
                        <label for="cantidad_users">Numero de licencias</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="date" class="form-control" id="fecha_inicial" name="fecha_inicial">
                        <label for="fecha_inicial">Fecha
                            inicial</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="date" class="form-control" id="fecha_final" name="fecha_final">
                        <label for="fecha_final">Fecha
                            final</label>
                    </div>
                    <input type="checkbox" class="btn-check" id="modulo24" autocomplete="off">
                    <label class="btn btn-outline-primary" for="modulo24">Todos</label>

                    <div class="container-fluid mt-2 " style="max-height: 100px; max-width:400px;overflow-y: scroll;">
                        <div class="row checkbox-container-create">
                            @foreach ($modules as $module)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" name="modulo_id" type="checkbox" id="modulo_id"
                                            value="{{ $module->id }}"></input>
                                        <label for="modulo_id">{{ $module->descripcion }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="btnCreateLicense" class="btn btn-success" tabindex="4">confirmar</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary"
                        tabindex="5">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade " id="editLicense" tabindex="-1" aria-labelledby="editLicenseLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-md ">
        <div class="modal-content">
            <form id="formEditlicense">
                <div class="modal-header ">
                    <h4 class="modal-title ml-1">Actualizar licencia</h4>
                    <div class="form-floating mx-5">
                        <select name="cliente_id" class="form-select" id="cliente_ids" name="cliente_id"
                            aria-label="cliente_id" autocomplete="off">
                            <option value="0"> Seleccione</option>
                            @foreach ($group as $companyGroup)
                                <option value="{{ $companyGroup->id }}">{{ $companyGroup->descripcion }}</option>
                            @endforeach
                        </select>
                        <label for="cliente_ids">grupo empresarial</label>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="empresa_id" list="datalistEmpresa_id"
                            placeholder="empresa_id" name="empresa_id">
                        <datalist id="datalistEmpresa_id">

                        </datalist>
                        <label for="empresa">empresa</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="codigo" placeholder="codigo"
                            name="codigo">
                        <label for="codigo">codigo</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="descripcion" placeholder="descripcion"
                            name="descripcion">
                        <label for="descripcion">Descripción licencia</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="cantidad_users"
                            placeholder="cantidadLicencias" name="cantidad_users">
                        <label for="cantidad_users">Numero de licencias</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="date" class="form-control" id="fecha_inicial" name="fecha_inicial">
                        <label for="fecha_inicial">Fecha
                            inicial</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="date" class="form-control" id="fecha_final" name="fecha_final">
                        <label for="fecha_final">Fecha
                            final</label>
                    </div>
                    <input type="checkbox" class="btn-check" id="moduloTodos" autocomplete="off">
                    <label class="btn btn-outline-primary" for="moduloTodos">Todos</label>

                    <div class="container-fluid mt-2 " style="max-height: 100px; max-width:400px;overflow-y: scroll;">
                        <div class="row checkbox-container-create">
                            @foreach ($modules as $module)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" name="modulo_id" type="checkbox"
                                            id="modulo_id" value="{{ $module->id }}"></input>
                                        <label for="modulo_id">{{ $module->descripcion }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="btnEditLicense" class="btn btn-success" tabindex="4">confirmar</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        class="btn btn-secondary" tabindex="5">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div id="deleteLicense" class="modal fade" tabindex="-1" aria-labelledby="deleteLicenseLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar la licencia?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteLicense" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>


<script>
    const checkboxTodos = document.querySelector("#moduloTodos");
    const checkboxes = document.querySelectorAll("[name^='modulo']");
    const selectedModules = new Set();

    checkboxTodos.addEventListener("change", function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = checkboxTodos.checked;
            if (checkbox.checked) {
                selectedModules.add(checkbox.value);
            } else {
                selectedModules.delete(checkbox.value);
            }
        });
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function() {
            if (!this.checked) {
                checkboxTodos.checked = false;
                selectedModules.delete(checkbox.value);
            } else {
                const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
                checkboxTodos.checked = allChecked;
                selectedModules.add(checkbox.value);
            }
            if (allChecked && this !== checkboxTodos) {
                checkboxTodos.checked = true;
            }
        });
    });


    function getSelectedModuleIds() {
        return Array.from(selectedModules);
    }
</script>
