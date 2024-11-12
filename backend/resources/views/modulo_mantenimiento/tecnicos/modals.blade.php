{{--modal de creación de solicitud--}}
<div class="modal fade " id="createTechnician" tabindex="-1" aria-labelledby="createTechnicianLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-md ">
        <div class="modal-content">
            <form id="formCreateTechnician">
                <div class="modal-header ">
                    <h4 class="modal-title ml-1" >Nueva asignación técnica</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="row">
                        <div class="col">
                            <div class="form-floating" >
                                <input class="form-control" type="text" id="tercero_id" list="tercero_id_list"   name="tercero_id" autocomplete="off">
                                <label for="tercero_id" class="">ID Solicitante</label>
                                <datalist id="tercero_id_list">
                                    @foreach ($selectores['tercero_id'] as $tercero)
                                    <option value="{{ $tercero->identificacion }}">
                                    {{ $tercero->nombre_completo}} {{$tercero->identificacion}}
                                    </option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div> 
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control"  id="especialidad" name="especialidad">
                                <label for="especialidad">Especialidad</label>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control"  id="apellidos_tecnicos" name="apellidos_tecnicos" readonly>
                                <label for="apellidos_tecnicos">Apellidos</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control"  id="nombres_tecnicos" name="nombres_tecnicos" readonly>
                                <label for="nombres_tecnicos">Nombres</label>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col">
                            <div class=" form-floating">
                                <input type="date" class="form-control" id="fecha_inicio" placeholder="fecha_inicio" name="fecha_inicio"></input>
                                <label for="fecha_inicio">Fecha de inicio</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="fecha_final" placeholder="fecha_final" name="fecha_final" readonly>
                                <label for="fecha_final">Fecha final</label>
                            </div>
                        </div>   
                    </div>
                    
                    <div class="row pt-3">
                        <div class="col">
                            <div class="form-floating">
                                <textarea class="form-control" value="observaciones" name="observaciones"
                                    id="observaciones"></textarea>
                                <label for="observaciones">Observaciones</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnCreateTechnician" class="btn btn-success" tabindex="4">Crear</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        class="btn btn-secondary" tabindex="5">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--modal de edición--}}
<div class="modal fade " id="updateTechnician" tabindex="-1" aria-labelledby="updateTechnicianLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-md ">
        <div class="modal-content">
            <form id="formUpdateTechnician">
                <div class="modal-header ">
                    <h4 class="modal-title ml-1" >Actualización de asignación técnica</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="row">
                        <div class="col">
                            <div class="form-floating" >
                                <input class="form-control" type="text" id="tercero_id" list="tercero_id_list"   name="tercero_id" autocomplete="off">
                                <label for="tercero_id" class="">ID Solicitante</label>
                                <datalist id="tercero_id_list">
                                    @foreach ($selectores['tercero_id'] as $tercero)
                                    <option value="{{ $tercero->identificacion }}">
                                    {{ $tercero->nombre_completo}} {{$tercero->identificacion}}
                                    </option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div> 
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control"  id="especialidad" name="especialidad">
                                <label for="especialidad">Especialidad</label>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control"  id="apellidos_tecnicos" name="apellidos_tecnicos" readonly>
                                <label for="apellidos_tecnicos">Apellidos</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control"  id="nombres_tecnicos" placeholder="nombres_tecnicos" name="nombres_tecnicos" readonly>
                                <label for="nombres_tecnicos">Nombres</label>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col">
                            <div class=" form-floating">
                                <input type="date" class="form-control" id="fecha_inicio" placeholder="fecha_inicio" name="fecha_inicio"></input>
                                <label for="fecha_inicio">Fecha de inicio</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="fecha_final" placeholder="fecha_final" name="fecha_final">
                                <label for="fecha_final">Fecha final</label>
                            </div>
                        </div>   
                    </div>
                    
                    <div class="row pt-3">
                        <div class="col">
                            <div class="form-floating">
                                <textarea class="form-control" value="observaciones" name="observaciones"
                                    id="observaciones"></textarea>
                                <label for="observaciones">Observaciones</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnUpdateTechnician" class="btn btn-success" tabindex="4">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        class="btn btn-secondary" tabindex="5">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- modal de eliminación solicitud --}}
<div id="deleteTechnician" class="modal fade" tabindex="-1" aria-labelledby="deleteTechnicianLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro/a que desea eliminar la asignación del técnico?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteTechnician" class="btn btn-danger delete" type="submit">Confirmar</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>