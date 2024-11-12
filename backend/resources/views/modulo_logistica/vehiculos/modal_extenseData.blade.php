<!-- Botón para abrir el modal de creación -->
<div class="modal fade" tabindex="-1" id="vehiclesCreate" aria-labelledby="vehiclesCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
        <!-- Modal -->
        <div class="modal-content">
            <!-- Cabecera del modal -->
            <div class="modal-header border border-0">
                <h4 class="modal-title uppercase">Gestión de vehículos</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Cuerpo del modal -->
            <div class="modal-body border border-0">
                <!-- Navegación de pestañas -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#pestaña1create">Información general</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pestaña2create">Datos técnicos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pestaña3create">Galería</a>
                    </li>
                </ul>
                <!-- Contenido de las pestañas -->
                <form id="formularion_creacion" class="form-control my-3 border border-0">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="pestaña1create">
                            <!--Contenido de la pestaña 1 -->
                            <div class="row mt-1">
                                <div class="col">
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="afiliacion" name="afiliacion"
                                            required>
                                        <label for="afiliacion">Fecha Afiliación</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="desvinculacion"
                                            name="desvinculacion" required>
                                        <label for="desvinculacion">Fecha Desvinculación</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="operacion" name="operacion"
                                            required>
                                        <label for="operacion">Fecha Operación</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h5 class="text-center uppercase">Propietario</h5>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input class="form-control" type="text" id="propietario_id" list="propietario_id_list"   name="propietario_id">
                                        <label for="propietario_id">Propietario</label>
                                        <datalist id="propietario_id_list">
                                            @foreach ($entidades['entidad_tercero'] as $clase)
                                            <option value="{{ $clase->identificacion }}">
                                            {{ $clase->apellidos}} {{$clase->nombres}} {{$clase->identificacion}}
                                            </option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="select" class="form-control" id="apellidos_propietario"
                                            name="apellidos_propietario" readonly>
                                        <label for="apellidos_propietario">Apellidos </label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="nombres_propietario"
                                            name="nombres_propietario" readonly>
                                        <label for="nombres_propietario">Nombres</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="movil_propietario"
                                            name="movil_propietario" readonly>
                                        <label for="movil_propietario">Telefono</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-1">

                                        <input type="text" class="form-control" id="email_propietario"
                                            list="propietario_id_list" name="email_propietario" readonly>
                                        <label for="email_propietario">Correo electrónico</label>

                                        <datalist id="propietario_id_list">
                                            @foreach ($entidades['entidad_tercero'] as $clase)
                                            <option value="{{ $clase->identificacion }}">
                                            {{ $clase->apellidos}} {{$clase->nombres}} {{$clase->identificacion}}
                                            </option>
                                            @endforeach
                                        </datalist>

                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h5 class="text-center uppercase">Conductor</h5>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input class="form-control" id="conductor_id" name="conductor_id"
                                            list="conductor_id_list">
                                        <label for="conductor_id">ID Conductor</label>
                                        <datalist id="conductor_id_list">
                                            @foreach ($entidades['entidad_tercero'] as $clase)
                                            <option value="{{ $clase->identificacion }}">
                                                {{ $clase->apellidos}} {{$clase->nombres}} {{$clase->identificacion}}
                                            </option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="apellidos_conductor"
                                            name="apellidos_conductor" readonly>
                                        <label for="apellidos_conductor">Apellidos</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="nombres_conductor"
                                            name="nombres_conductor" readonly>
                                        <label for="nombres_conductor">Nombres</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="movil_conductor"
                                            name="movil_conductor" readonly>
                                        <label for="movil_conductor">Telefono</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="email_conductor"
                                            name="email_conductor" readonly>
                                        <label for="email_conductor">Correo electrónico</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h5 class="text-center uppercase">Matrícula</h5>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="matricula" name="matricula" disabled
                                            readonly>
                                        <label for="matricula">No. de matricula</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="propio">
                                            <label class="form-check-label" for="propio">Propio</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="modificado">
                                            <label class="form-check-label" for="modificado">Modificado</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <select name="vehiculo_clase_id" class="form-select" id="vehiculo_clase_id"
                                            name="vehiculo_clase_id">
                                            <option value="0" selected>Seleccione</option>
                                            @foreach ($entidades['entidad_clases'] as $clase)
                                            <option value="{{ $clase->id }}">
                                                {{ $clase->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="entidad_clases">clase vehiculo</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistGrupo_vehiculo_id"
                                            id="grupo_vehiculo_id" name="grupo_vehiculo_id">
                                        <datalist id="datalistGrupo_vehiculo_id">
                                            @foreach ($entidades['entidad_grupo_vehiculo'] as $grupo)
                                            <option value="{{ $grupo->id }} - {{ $grupo->descripcion }}">{{
                                                $grupo->descripcion }}</option>
                                            @endforeach
                                        </datalist>
                                        <label for="grupo_vehiculo_id">grupo vehículo</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <select name="tipo_contrato_id" class="form-select" id="tipo_contrato_id"
                                            name="tipo_contrato_id">
                                            <option value="0" selected>Seleccione</option>
                                            @foreach ($entidades['entidad_contratos'] as $contrato)
                                            <option value="{{ $contrato->id }}">
                                                {{ $contrato->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="tipo_contrato_id">Tipo de contrato</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="combustible_id" name="combustible_id"
                                            aria-label="Combustible">
                                            <option value="0" selected>Seleccione</option>
                                            @foreach ($entidades['entidad_combustible'] as $combustible)
                                            <option value="{{ $combustible->id }}">
                                                {{ $combustible->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="combustible_id">combustible</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="blindaje_id" id="blindaje_id"
                                            aria-label="blindaje_id">
                                            <option value="0" selected>Seleccione</option>
                                            @foreach ($entidades['entidad_blindaje'] as $blindaje)
                                            <option value="{{ $blindaje->id }}">
                                                {{ $blindaje->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="blindaje_id">blindaje</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <select name="ejes_id" class="form-select" id="ejes_id" name="ejes_id"
                                            aria-label="ejes_id">
                                            <option value="0" selected>Seleccione</option>
                                            @foreach ($entidades['entidad_ejes'] as $eje)
                                            <option value="{{ $eje->id }}">
                                                {{ $eje->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="ejes_id">ejes</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pestaña2create">
                            <!--Contenido de la pestaña 2 -->
                            <h5 class="text-center">Datos del vehículo</h5>
                            <div class="row ">
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="vehiculo_placa"
                                            name="vehiculo_placa" required>
                                        <label for="vehiculo_placa">placa</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <select name="vehiculo_marca_id" class="form-select" id="vehiculo_marca_id"
                                            name="vehiculo_marca_id" aria-label="vehiculo_marca_id">
                                            <option value="0" selected>Seleccione</option>
                                            @foreach ($entidades['entidad_marca'] as $marca)
                                            <option value="{{ $marca->id }}">
                                                {{ $marca->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="vehiculo_marca_id">Marca</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="vehiculo_modelo"
                                            name="vehiculo_modelo" required>
                                        <label for="vehiculo_modelo">modelo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="vehiculo_linea"
                                            name="vehiculo_linea" required>
                                        <label for="vehiculo_linea">linea</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="vehiculo_color"
                                            name="vehiculo_color" required>
                                        <label for="vehiculo_color">color</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="vehiculo_serial_motor"
                                            name="vehiculo_serial_motor" required>
                                        <label for="vehiculo_serial_motor">serial motor</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="vehiculo_serial_chasis"
                                            name="vehiculo_serial_chasis" required>
                                        <label for="vehiculo_serial_chasis">Serial chasis</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gps_empresa" name="gps_empresa"
                                            required>
                                        <label for="gps_empresa">GPS empresa</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gps_usuario" name="gps_usuario"
                                            required>
                                        <label for="gps_usuario">GPS usuario</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gps_password" name="gps_password"
                                            required>
                                        <label for="gps_password">GPS password</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gps_id" name="gps_id" required>
                                        <label for="gps_id">GPS id</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gps_numero" name="gps_numero"
                                            required>
                                        <label for="gps_numero">GPS numero</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="file" class="form-control" name="ruta_imagen" id="ruta_imagen" />
                                        <label for="ruta_imagen"><strong>Foto</strong></label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="trailer_modelo"
                                            name="trailer_modelo" required>
                                        <label for="trailer_modelo">modelo trailer</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalisttrailer_id" id="trailer_id"
                                            name="trailer_id">
                                        <datalist id="datalisttrailer_id">
                                            @foreach ($entidades['entidad_trailer'] as $trailer)
                                            <option value="{{ $trailer->id }} - {{ $trailer->descripcion }}"></option>
                                            @endforeach
                                        </datalist>
                                        <label for="trailer_id">trailer</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <textarea class="form-control" value="observacion" name="observacion"
                                            id="observacion"></textarea>
                                        <label for="observacion">Observaciones</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <img src="http://181.48.57.46:8083/imagenes/Sgju118SpEmmjMjy0n6pHmhKhmnNaWpPQoUHw2oGio4In60Le5F82SGDioQ2dHyKN6JUp1tIPyRz1jYYNZLJQlEDeSYOU2JZe21ysZu3JHSDESmY17dNyfYI.png"
                                        id="imagen_vehiculo" alt="imagen_vehiculo" style="max-height: 150px;">
                                </div>
                            </div>
                            <hr>
                            <h5 class="text-center">Datos técnicos vehículo</h5>
                            <div class="row">
                                <div class="col-3 mt-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="soat_empresa" name="soat_empresa"
                                            required>
                                        <label for="soat_empresa">SOAT empresa</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="soat_valor" name="soat_valor"
                                            required>
                                        <label for="soat_valor">SOAT valor</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="soat_ini" name="soat_ini" required>
                                        <label for="soat_ini">Fecha inicial</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="soat_fin" name="soat_fin" required>
                                        <label for="soat_fin">fecha final</label>
                                    </div>
                                </div>
                                <div class="col-3 mt-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gases_empresa" name="gases_empresa"
                                            required>
                                        <label for="gases_empresa">gases empresa</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gases_valor" name="gases_valor"
                                            required>
                                        <label for="gases_valor">gases valor</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="gases_ini" name="gases_ini"
                                            required>
                                        <label for="gases_ini">Fecha inicial</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="gases_fin" name="gases_fin"
                                            required>
                                        <label for="gases_fin">fecha final</label>
                                    </div>
                                </div>
                                <div class="col-3 mt-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="seguro_empresa"
                                            name="seguro_empresa" required>
                                        <label for="seguro_empresa">seguro empresa</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="seguro_valor" name="seguro_valor"
                                            required>
                                        <label for="seguro_valor">seguro valor</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="seguro_ini" name="seguro_ini"
                                            required>
                                        <label for="seguro_ini">Fecha inicial</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="seguro_fin" name="seguro_fin"
                                            required>
                                        <label for="seguro_fin">fecha final</label>
                                    </div>

                                </div>
                                <div class="col-2 mt-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="cilindraje" name="cilindraje"
                                            required>
                                        <label for="cilindraje">cilindraje</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="tara" name="tara" required>
                                        <label for="tara">tara vehiculo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="pasajeros" name="pasajeros"
                                            required>
                                        <label for="pasajeros">pasajeros</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="km_ini" name="km_ini" required>
                                        <label for="km_ini">kilometraje inicial</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pestaña3create">
                            <!--Contenido de la pestaña 3 -->

                        </div>
                    </div>
                </form>
                <!-- Pie del modal -->
                <div class="modal-footer border border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnSaveVehicle">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Botón para abrir el modal de edición -->
<div class="modal fade" tabindex="-1" id="vehiclesUpdate" aria-labelledby="vehiclesUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
        <!-- Modal -->
        <div class="modal-content">
            <!-- Cabecera del modal -->
            <div class="modal-header border border-0">
                <h4 class="modal-title">Gestión de vehículos</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <!-- Navegación de pestañas -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#pestaña1update">Información general</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pestaña2update">Datos técnicos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#pestaña3update">Galería</a>
                    </li>
                </ul>
                <!-- Contenido de las pestañas -->
                <form id="updateSpecs" class="form-control my-3 border border-0">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="pestaña1update">
                            <!--Contenido de la pestaña 1 -->
                            <div class="row mt-1">
                                <div class="col">
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="afiliacion" name="afiliacion"
                                            required>
                                        <label for="afiliacion">Fecha Afiliación</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="desvinculacion"
                                            name="desvinculacion" required>
                                        <label for="desvinculacion">Fecha Desvinculación</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="operacion" name="operacion"
                                            required>
                                        <label for="operacion">Fecha Operación</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h5 class="text-center uppercase">Propietario</h5>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input class="form-control" type="text" list="propietario_id_list" id="propietario_id"
                                            name="propietario_id">
                                        <label for="propietario_id">Propietario</label>
                                        <datalist id="propietario_id_list">
                                            @foreach ($entidades['entidad_tercero'] as $clase)
                                            <option value="{{ $clase->identificacion }}">
                                                {{ $clase->nombre_completo}} {{$clase->identificacion}}
                                            </option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="select" class="form-control" id="apellidos_propietario"
                                            name="apellidos_propietario" readonly>
                                        <label for="apellidos_propietario">Apellidos </label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="nombres_propietario"
                                            name="nombres_propietario" readonly>
                                        <label for="nombres_propietario">Nombres</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="movil_propietario"
                                            name="movil_propietario" readonly>
                                        <label for="movil_propietario">Telefono</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="email_propietario"
                                            name="email_propietario" readonly>
                                        <label for="email_propietario">Correo electrónico</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h5 class="text-center uppercase">Conductor</h5>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input class="form-control" id="conductor_id" name="conductor_id"
                                            list="conductor_id_list">
                                        <label for="conductor_id">ID Conductor</label>

                                        <datalist id="conductor_id_list">
                                            @foreach ($entidades['entidad_tercero'] as $clase)
                                            <option value="{{ $clase->identificacion }}">
                                            {{ $clase->apellidos}} {{$clase->nombres}} {{$clase->identificacion}}
                                            </option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="apellidos_conductor"
                                            name="apellidos_conductor" readonly>
                                        <label for="apellidos_conductor">Apellidos</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="nombres_conductor"
                                            name="nombres_conductor" readonly>
                                        <label for="nombres_conductor">Nombres</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="movil_conductor"
                                            name="movil_conductor" readonly>
                                        <label for="movil_conductor">Telefono</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="email_conductor"
                                            name="email_conductor" readonly>
                                        <label for="email_conductor">Correo electrónico</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h5 class="text-center uppercase">Matrícula</h5>
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="matricula" name="matricula"
                                            required>
                                        <label for="matricula">No. de matricula</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-1" id="checkedInput">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="propio" id="propio">
                                            <label class="form-check-label" for="propio">Propio</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="modificado"
                                                id="modificado">
                                            <label class="form-check-label" for="modificado">Modificado</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <select name="vehiculo_clase_id" class="form-select" id="vehiculo_clase_id"
                                            name="vehiculo_clase_id">
                                            <option value="0" selected>Seleccione</option>
                                            @foreach ($entidades['entidad_clases'] as $clase)
                                            <option value="{{ $clase->id }}">
                                                {{ $clase->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="entidad_clases">clase vehiculo</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistGrupo_vehiculo_id"
                                            id="grupo_vehiculo_id" name="grupo_vehiculo_id">
                                        <datalist id="datalistGrupo_vehiculo_id">
                                            @foreach ($entidades['entidad_grupo_vehiculo'] as $grupo)
                                            <option value="{{ $grupo->id }} - {{ $grupo->descripcion }}">{{
                                                $grupo->descripcion }}</option>
                                            @endforeach
                                        </datalist>
                                        <label for="grupo_vehiculo_id">grupo vehículo</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <select name="tipo_contrato_id" class="form-select" id="tipo_contrato_id"
                                            name="tipo_contrato_id">
                                            <option value="0" selected>Seleccione</option>
                                            @foreach ($entidades['entidad_contratos'] as $contrato)
                                            <option value="{{ $contrato->id }}">
                                                {{ $contrato->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="tipo_contrato_id">Tipo de contrato</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="combustible_id" name="combustible_id"
                                            aria-label="Combustible">
                                            <option value="0" selected>Seleccione</option>
                                            @foreach ($entidades['entidad_combustible'] as $combustible)
                                            <option value="{{ $combustible->id }}">
                                                {{ $combustible->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="combustible_id">combustible</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" name="blindaje_id" id="blindaje_id"
                                            aria-label="blindaje_id">
                                            <option value="0" selected>Seleccione</option>
                                            @foreach ($entidades['entidad_blindaje'] as $blindaje)
                                            <option value="{{ $blindaje->id }}">
                                                {{ $blindaje->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="blindaje_id">blindaje</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <select name="ejes_id" class="form-select" id="ejes_id" name="ejes_id"
                                            aria-label="ejes_id">
                                            <option value="0" selected>Seleccione</option>
                                            @foreach ($entidades['entidad_ejes'] as $eje)
                                            <option value="{{ $eje->id }}">
                                                {{ $eje->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="ejes_id">ejes</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pestaña2update">
                            <!--Contenido de la pestaña 2 -->
                            <h5 class="text-center">Datos del vehículo</h5>
                            <div class="row ">
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="vehiculo_placa"
                                            name="vehiculo_placa" required>
                                        <label for="vehiculo_placa">placa</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <select name="vehiculo_marca_id" class="form-select" id="vehiculo_marca_id"
                                            name="vehiculo_marca_id" aria-label="vehiculo_marca_id">
                                            <option value="0" selected>Seleccione</option>
                                            @foreach ($entidades['entidad_marca'] as $marca)
                                            <option value="{{ $marca->id }}">
                                                {{ $marca->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="vehiculo_marca_id">Marca</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="vehiculo_modelo"
                                            name="vehiculo_modelo" required>
                                        <label for="vehiculo_modelo">modelo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="vehiculo_linea"
                                            name="vehiculo_linea" required>
                                        <label for="vehiculo_linea">linea</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="vehiculo_color"
                                            name="vehiculo_color" required>
                                        <label for="vehiculo_color">color</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="vehiculo_serial_motor"
                                            name="vehiculo_serial_motor" required>
                                        <label for="vehiculo_serial_motor">serial motor</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="vehiculo_serial_chasis"
                                            name="vehiculo_serial_chasis" required>
                                        <label for="vehiculo_serial_chasis">Serial chasis</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gps_empresa" name="gps_empresa"
                                            required>
                                        <label for="gps_empresa">GPS empresa</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gps_usuario" name="gps_usuario"
                                            required>
                                        <label for="gps_usuario">GPS usuario</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gps_password" name="gps_password"
                                            required>
                                        <label for="gps_password">GPS password</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gps_id" name="gps_id" required>
                                        <label for="gps_id">GPS id</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gps_numero" name="gps_numero"
                                            required>
                                        <label for="gps_numero">GPS numero</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-1">
                                        <input type="file" class="form-control" name="ruta_imagen" id="ruta_imagen" />
                                        <label for="ruta_imagen"><strong>Foto</strong></label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="trailer_modelo"
                                            name="trailer_modelo" required>
                                        <label for="trailer_modelo">modelo trailer</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalisttrailer_id" id="trailer_id"
                                            name="trailer_id">
                                        <datalist id="datalisttrailer_id">
                                            @foreach ($entidades['entidad_trailer'] as $trailer)
                                            <option value="{{ $trailer->id }} - {{ $trailer->descripcion }}"></option>
                                            @endforeach
                                        </datalist>
                                        <label for="trailer_id">trailer</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <textarea class="form-control" value="observacion" name="observacion"
                                            id="observacion"></textarea>
                                        <label for="observacion">Observaciones</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <img src="http://181.48.57.46:8083/imagenes/Sgju118SpEmmjMjy0n6pHmhKhmnNaWpPQoUHw2oGio4In60Le5F82SGDioQ2dHyKN6JUp1tIPyRz1jYYNZLJQlEDeSYOU2JZe21ysZu3JHSDESmY17dNyfYI.png"
                                        id="imagen_vehiculo" alt="imagen_vehiculo" style="max-height: 150px;">
                                </div>
                            </div>
                            <hr>
                            <h5 class="text-center">Datos técnicos vehículo</h5>
                            <div class="row">
                                <div class="col-3 mt-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="soat_empresa" name="soat_empresa"
                                            required>
                                        <label for="soat_empresa">SOAT empresa</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="soat_valor" name="soat_valor"
                                            required>
                                        <label for="soat_valor">SOAT valor</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="soat_ini" name="soat_ini" required>
                                        <label for="soat_ini">Fecha inicial</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="soat_fin" name="soat_fin" required>
                                        <label for="soat_fin">fecha final</label>
                                    </div>
                                </div>
                                <div class="col-3 mt-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gases_empresa" name="gases_empresa"
                                            required>
                                        <label for="gases_empresa">gases empresa</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="gases_valor" name="gases_valor"
                                            required>
                                        <label for="gases_valor">gases valor</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="gases_ini" name="gases_ini"
                                            required>
                                        <label for="gases_ini">Fecha inicial</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="gases_fin" name="gases_fin"
                                            required>
                                        <label for="gases_fin">fecha final</label>
                                    </div>
                                </div>
                                <div class="col-3 mt-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="seguro_empresa"
                                            name="seguro_empresa" required>
                                        <label for="seguro_empresa">seguro empresa</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="seguro_valor" name="seguro_valor"
                                            required>
                                        <label for="seguro_valor">seguro valor</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="seguro_ini" name="seguro_ini"
                                            required>
                                        <label for="seguro_ini">Fecha inicial</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="seguro_fin" name="seguro_fin"
                                            required>
                                        <label for="seguro_fin">fecha final</label>
                                    </div>
                                </div>
                                <div class="col-2 mt-3">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="cilindraje" name="cilindraje"
                                            required>
                                        <label for="cilindraje">cilindraje</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="tara" name="tara" required>
                                        <label for="tara">tara vehiculo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="pasajeros" name="pasajeros"
                                            required>
                                        <label for="pasajeros">pasajeros</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="km_ini" name="km_ini" required>
                                        <label for="km_ini">kilometraje inicial</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pestaña3update">
                            <!--Contenido de la pestaña 3 -->
                        </div>
                    </div>
                </form>
                <!-- Pie del modal -->
                <div class="modal-footer border border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnUpdateVehicle">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="DeleteVehicle" class="modal fade" tabindex="-1" aria-labelledby="DeleteVehicleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el vehículo?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteVehicle" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>