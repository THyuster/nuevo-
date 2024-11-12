<!-- Creación de año fiscal - modal-->
<div id="createPeriod" class="modal fade" tabindex="-1" aria-labelledby="createPeriodLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formularioCrear" action="">
                <div class="modal-header">
                    <h4>Creación de periodo</h4>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-1">
                        <select class="form-select" id="afiscal_id" name="afiscal_id" aria-label="Año fiscal" required>
                            @foreach ($fiscalYear as $fiscalYears)
                            <option value="{{$fiscalYears->id}}">{{$fiscalYears->afiscal}}</option>
                            @endforeach
                            <label for="afiscal_id">Año fiscal</label>
                        </select>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" id="codigo" class="form-control" name="codigo" min="2000" max="2024"
                            pattern="\d{4}" required>
                        <label for="codigo">Código</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        <label for="descripcion">Descripción</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        <label for="fecha_inicio">fecha inicial</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="date" class="form-control" id="fecha_final" name="fecha_final" required>
                        <label for="fecha_final">fecha final</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnCreatePeriod" class="btn btn-primary" type="submit">Crear</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal de edición de años fiscales -->
<div id="editPeriod" class="modal fade" tabindex="-1" aria-labelledby="editPeriodLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formularioActualizar" action="">
                <div class="modal-header">
                    <h4>Edición de periodo</h4>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-1">
                        <select class="form-select" id="afiscal_id" name="afiscal_id" aria-label="Año fiscal" required>
                            @foreach ($fiscalYear as $fiscalYears)
                            <option value="{{$fiscalYears->id}}">{{$fiscalYears->afiscal}}</option>
                            @endforeach
                            <label for="afiscal_id">Año fiscal</label>
                        </select>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" id="codigo" class="form-control" name="codigo" min="2000" max="2024"
                            pattern="\d{4}" required>
                        <label for="codigo">Código</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                        <label for="descripcion">Descripción</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        <label for="fecha_inicio">fecha inicial</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="date" class="form-control" id="fecha_final" name="fecha_final" required>
                        <label for="fecha_final">fecha final</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnEditPeriod" class="btn btn-primary" type="submit">Crear</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de eliminación de año fiscal-->
<div id="deletePeriod" class="modal fade" tabindex="-1" aria-labelledby="deletePeriodLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el periodo?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeletePeriod" class="btn btn-primary" type="submit">Confirmar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div id="cloneFiscalYear" class="modal fade" tabindex="-1" aria-labelledby="cloneFiscalYearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Clonación de año fiscal</h4>
            </div>
            <div class="modal-body">
                <form id="cloneYear">
                    <p class="text-center">Seleccione el año fiscal que desee clonar</p>
                    <select class="form-select mb-3" id="lastYear" name="lastYear" aria-label="Año fiscal" required>
                        @foreach ($fiscalYear as $fiscalYears)
                        <option value="{{$fiscalYears->id}}">{{$fiscalYears->afiscal}}</option>
                        @endforeach
                        <label for="lastYear">Año fiscal</label>
                    </select>
                    <p class="text-center">Seleccione el año fiscal actual</p>
                    <select class="form-select" id="yearNew" name="yearNew" aria-label="yearNew" required>
                        @foreach ($fiscalYear as $fiscalYears)
                        <option value="{{$fiscalYears->id}}">{{$fiscalYears->afiscal}}</option>
                        @endforeach
                        <label for="yearNew">Año Objetivo</label>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnCloneFiscalYear" class="btn btn-primary" type="submit">Confirmar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>