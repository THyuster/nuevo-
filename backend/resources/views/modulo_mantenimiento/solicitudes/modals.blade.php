{{--modal de creación de solicitud--}}
<div class="modal fade " id="createRequest" tabindex="-1" aria-labelledby="createRequestLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-xl ">
        <div class="modal-content">
            <form id="formCreateRequest">
                <div class="modal-header ">
                    <h4 class="modal-title ml-1" >Nueva solicitud</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="row">
                        <div class="col">
                            <div class=" form-floating">
                                <input type="date" class="form-control" id="fecha_solicitud" placeholder="fecha_solicitud" name="fecha_solicitud" value="{{ date('Y-m-d') }}" disabled></input>
                                <label for="fecha_solicitud">fecha de solicitud</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="fecha_cierre" placeholder="fecha_cierre" name="fecha_cierre" disabled>
                                <label for="fecha_cierre">fecha de cierre</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <select name="estado_id" class="form-select" id="estado_id" aria-label="estado" disabled>
                                    {{-- <option value="0" selected>Seleccione</option> --}}
                                    @foreach ($selectores['estado_id'] as $estados)
                                        <option value="{{ $estados->id }}">
                                            {{ $estados->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="estado">estado</label>
                            </div>
                        </div>
                    </div>
                        <h5 class="text-center mt-3">INFORMACIÓN</h5>
                        
                        <div class="row ">
                            <div class="col-9">

                                <div class="row mb-2">
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
                                            <input type="text" class="form-control"  id="apellidos_solicitante" name="apellidos_solicitante">
                                            <label for="apellidos_solicitante" class="">Apellidos</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control"  id="nombres_solicitante" name="nombres_solicitante">
                                            <label for="nombres_solicitante" >Nombres</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="email_solicitante" name="email_solicitante" class="form-control" id="email_solicitante" required>
                                            <label for="email_solicitante" >Correo Electronico</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="number" class="form-control is-required" name="movil_solicitante" id="movil_solicitante">
                                            <label for="movil_solicitante" >Número de Celular</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <select name="centro_trabajo_id" class="form-select" id="centro_trabajo_id" name="centro_trabajo_id" aria-label="centro_trabajo_id">
                                                <option value="0" selected>Seleccione</option>
                                                @foreach ($selectores['centro_trabajo_id'] as $centro_trabajo)
                                                <option value="{{ $centro_trabajo->id }}">
                                                    {{ $centro_trabajo->descripcion }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="centro_trabajo_id">Centro de trabajo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-floating">
                                            <select name="prioridad_id" class="form-select" id="prioridad_id" name="prioridad_id" aria-label="prioridad_id">
                                                    <option value="0" selected>Seleccione</option>
                                                    @foreach ($selectores['prioridad_id'] as $prioridades)
                                                    <option value="{{ $prioridades->id }}">
                                                        {{ $prioridades->nombre }}
                                                    </option>
                                                    @endforeach
                                            </select>
                                            <label for="prioridad">prioridad</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <select name="equipo_id" class="form-select" id="equipo_id" name="equipo_id" aria-label="equipo_id">
                                                <option value="0" selected>Seleccione</option>
                                                @foreach ($selectores['equipo_id'] as $equipo)
                                                <option value="{{ $equipo->id }}">
                                                    {{ $equipo->descripcion }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="equipo_id">equipo</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <select name="vehiculo_id" class="form-select" id="vehiculo_id" name="vehiculo_id" aria-label="vehiculo_id">
                                                <option value="0" selected>Seleccione</option>
                                                @foreach ($selectores['vehiculo_id'] as $vehiculo)
                                                <option value="{{ $vehiculo->id }}">
                                                    {{ $vehiculo->matricula }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="vehiculo_id">vehículo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <div class="form-floating" >
                                            <select name="tipo_solicitud_id" class="form-select" id="tipo_solicitud_id" aria-label="tipo_solicitud_id">
                                                <option value="0" selected>Seleccione</option>
                                                @foreach ($selectores['tipo_solicitud_id'] as $tipo_solicitud)
                                                <option value="{{ $tipo_solicitud->id }}">
                                                    {{ $tipo_solicitud->descripcion }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="tipo_solicitud_id">tipo de solicitud</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <textarea class="form-control" value="observacion" name="observacion"
                                                id="observacion"></textarea>
                                            <label for="observacion">Observaciones</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-3">
                                <div class="col">
                                    <div class="form-floating mb-2">
                                        <input type="file" class="form-control" name="ruta_imagen" id="ruta_imagen">
                                        <label for="ruta_imagen"><strong>Foto</strong></label>
                                    </div>      
                                    <img id="ruta_imagen" src="http://181.48.57.46:8083/imagenes/Sgju118SpEmmjMjy0n6pHmhKhmnNaWpPQoUHw2oGio4In60Le5F82SGDioQ2dHyKN6JUp1tIPyRz1jYYNZLJQlEDeSYOU2JZe21ysZu3JHSDESmY17dNyfYI.png" class="img-thumbnail  img-fluid mx-auto d-block" width="100%">
                                </div>
                            </div>
                        </div> 
                    </div>
                <div class="modal-footer">
                    <button id="btnCreateRequest" class="btn btn-success" tabindex="4">Crear</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        class="btn btn-secondary" tabindex="5">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--modal de edición--}}
<div class="modal fade " id="updateRequest" tabindex="-1" aria-labelledby="updateRequestLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-xl ">
        <div class="modal-content">
            <form id="formUpdateRequest">
                <div class="modal-header ">
                    <h4 class="modal-title ml-1" >Editar Solicitud</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <input type="input" class="form-control" id="numero_solicitud" name="numero_solicitud"></input>
                                <label for="numero_solicitud">Numero solicitud</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class=" form-floating">
                                <input type="datetime-local" class="form-control" id="fecha_solicitud" placeholder="fecha_solicitud" name="fecha_solicitud" disabled></input>
                                <label for="fecha_solicitud">fecha de solicitud</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="datetime-local" class="form-control" id="fecha_cierre" placeholder="fecha_cierre" name="fecha_cierre">
                                <label for="fecha_cierre">fecha de cierre</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <select name="estado_id" class="form-select" id="estado_id" aria-label="estado">
                                    <option value="0" selected>Seleccione</option>
                                    @foreach ($selectores['estado_id'] as $estados)
                                        <option value="{{ $estados->id }}">
                                            {{ $estados->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="estado">estado</label>
                            </div>
                        </div>
                    </div>
                        <h5 class="text-center mt-3">INFORMACIÓN</h5>
                        
                        <div class="row ">
                            <div class="col-9">

                                <div class="row mb-2">
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
                                            <input type="text" class="form-control"  id="apellidos_solicitante" name="apellidos_solicitante">
                                            <label for="apellidos_solicitante" class="">Apellidos</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control"  id="nombres_solicitante" name="nombres_solicitante">
                                            <label for="nombres_solicitante" >Nombres</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="email_solicitante" name="email_solicitante" class="form-control" id="email_solicitante" required>
                                            <label for="email_solicitante" >Correo Electronico</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="number" class="form-control is-required" name="movil_solicitante" id="movil_solicitante">
                                            <label for="movil_solicitante" >Número de Celular</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <select name="centro_trabajo_id" class="form-select" id="centro_trabajo_id" name="centro_trabajo_id" aria-label="centro_trabajo_id">
                                                <option value="0" selected>Seleccione</option>
                                                @foreach ($selectores['centro_trabajo_id'] as $centro_trabajo)
                                                <option value="{{ $centro_trabajo->id }}">
                                                    {{ $centro_trabajo->descripcion }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="centro_trabajo_id">Centro de trabajo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="form-floating">
                                            <select name="prioridad_id" class="form-select" id="prioridad_id" name="prioridad_id" aria-label="prioridad_id">
                                                    <option value="0" selected>Seleccione</option>
                                                    @foreach ($selectores['prioridad_id'] as $prioridades)
                                                    <option value="{{ $prioridades->id }}">
                                                        {{ $prioridades->nombre }}
                                                    </option>
                                                    @endforeach
                                            </select>
                                            <label for="prioridad">prioridad</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <select name="equipo_id" class="form-select" id="equipo_id" name="equipo_id" aria-label="equipo_id">
                                                <option value="0" selected>Seleccione</option>
                                                @foreach ($selectores['equipo_id'] as $equipo)
                                                <option value="{{ $equipo->id }}">
                                                    {{ $equipo->descripcion }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="equipo_id">equipo</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <select name="vehiculo_id" class="form-select" id="vehiculo_id" name="vehiculo_id" aria-label="vehiculo_id">
                                                <option value="0" selected>Seleccione</option>
                                                @foreach ($selectores['vehiculo_id'] as $vehiculo)
                                                <option value="{{ $vehiculo->id }}">
                                                    {{ $vehiculo->matricula }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="vehiculo_id">vehículo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4">
                                        <div class="form-floating" >
                                            <select name="tipo_solicitud_id" class="form-select" id="tipo_solicitud_id" aria-label="tipo_solicitud_id">
                                                <option value="0" selected>Seleccione</option>
                                                @foreach ($selectores['tipo_solicitud_id'] as $tipo_solicitud)
                                                <option value="{{ $tipo_solicitud->id }}">
                                                    {{ $tipo_solicitud->descripcion }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label for="tipo_solicitud_id">tipo de solicitud</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <textarea class="form-control" value="observacion" name="observacion"
                                                id="observacion"></textarea>
                                            <label for="observacion">Observaciones</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="col">
                                    <div class="form-floating mb-2">
                                        <input type="file" class="form-control" name="ruta_imagen" id="ruta_imagen">
                                        <label for="ruta_imagen"><strong>Foto</strong></label>
                                    </div>      
                                    <img id="imagen_solicitud" src="http://181.48.57.46:8083/imagenes/Sgju118SpEmmjMjy0n6pHmhKhmnNaWpPQoUHw2oGio4In60Le5F82SGDioQ2dHyKN6JUp1tIPyRz1jYYNZLJQlEDeSYOU2JZe21ysZu3JHSDESmY17dNyfYI.png" class="img-thumbnail  img-fluid mx-auto d-block" width="100%">
                                </div> 
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <a id="btnUpdateRequest" class="btn btn-success" tabindex="4">Actualizar</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary" tabindex="5">Cancelar</button>
                    </div>
            </form>
        </div>
    </div>
</div>

{{-- modal de eliminación solicitud --}}
<div id="deleteRequest" class="modal fade" tabindex="-1" aria-labelledby="deleteRequestLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro/a que desea eliminar la solicitud?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteRequest" class="btn btn-danger delete" type="submit">Confirmar</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>