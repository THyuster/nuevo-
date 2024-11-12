<!-- Creación de año fiscal - modal-->
<div id="createFiscalYear" class="modal fade" tabindex="-1" aria-labelledby="createFiscalYearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Creación de año fiscal</h4>
            </div>
            <div class="modal-body">
                <form id="formularioCrear" action="">
                    <div class="form-floating mb-3">
                        <input class="form-control" list="datalistEmpresa_id" id="empresa_id"
                            name="empresa_id" placeholder="empresa_id" autocomplete="off">
                        <datalist id="datalistEmpresa_id">
                            @foreach ($companies as $company)
                            <option value="{{ $company->id}} - {{$company->razon_social}}">
                                @endforeach
                        </datalist>
                        <label for="empresa_id">ID Empresa</label>
                    </div>
                    <div class="form-floating mb-1">
                    <input type="number" id="afiscal" class="form-control" name="afiscal" required min="2000" max="2024" pattern="\d{4}" required>
                        <label for="afiscal">Año fiscal</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="descripcion"
                            name="descripcion" required>
                        <label for="descripcion">Descripción</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCreateFiscalYear" class="btn btn-primary" type="submit">Crear</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!--Modal de edición de años fiscales -->
<div id="editFiscalYear" class="modal fade" tabindex="-1" aria-labelledby="editFiscalYearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>edición de Año fiscal</h4>
            </div>
            <div class="modal-body">
                <form id="formularioActualizar" action="">
                    <div class="form-floating mb-3">
                        <input class="form-control" list="datalistEmpresa_id" id="empresa_id"
                            name="empresa_id" placeholder="empresa_id" autocomplete="off">
                        <datalist id="datalistEmpresa_id">
                            @foreach ($companies as $company)
                            <option value="{{ $company->id}} - {{$company->razon_social}}">
                                @endforeach
                        </datalist>
                        <label for="empresa_id">ID Empresa</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="number" class="form-control" id="afiscal"
                            name="afiscal" required>
                        <label for="afiscal">Año fiscal</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="descripcion"
                            name="descripcion" required>
                        <label for="descripcion">Descripción</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnEditFiscalYear" class="btn btn-primary" type="submit">Actualizar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de eliminación de año fiscal-->
<div id="deleteFiscalYear" class="modal fade" tabindex="-1" aria-labelledby="deleteFiscalYearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el año fiscal?</p>
            </div>
            <div class="modal-footer">
                <button id="btndDeleteFiscalYear" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

