<!-- Botón para abrir el modal -->
<div class="modal fade" tabindex="-1" id="createDevices" aria-labelledby="createDevicesLabel" aria-hidden="true">
    
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
    <!-- Modal -->
        <div class="modal-content">
        <!-- Cabecera del modal -->
            <div class="modal-header">
                <h4 class="modal-title">Gestión de equipos</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <!-- Navegación de pestañas -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" data-toggle="tab" href="#pestaña1create">Especificaciones generales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" aria-current="page" href="#pestaña2create">Especificaciones técnicas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" aria-current="page" href="#pestaña3create">Galería</a>
                    </li>
                </ul>
                <!-- Contenido de las pestañas -->
                <form action="" id="mainSpecs" class="form-control mt-3">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pestaña1create">
                            <!--Contenido de la pestaña 1 -->
                            <div class="row">
                                <div class="col-3 mt-3">
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="fecha_adquisicion"
                                            name="fecha_adquisicion" required>
                                        <label for="fecha_adquisicion">Fecha de adquisición</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistGrupo_equipo_id" id="grupo_equipo_id"
                                            name="grupo_equipo_id" autocomplete="off">
                                        <datalist id="datalistGrupo_equipo_id">
                                            @foreach ($fixedAssets as $fixedAsset)
                                            <option value="{{ $fixedAsset->id}} - {{$fixedAsset->descripcion}}">
                                                @endforeach
                                        </datalist>
                                        <label for="grupo_equipo_id">grupo de equipo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="serial_equipo"
                                            name="serial_equipo" required>
                                        <label for="serial_equipo">Serial equipo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="serial_interno"
                                            name="serial_interno" required>
                                        <label for="serial_interno">Serial interno</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="modelo"
                                            name="modelo" required>
                                        <label for="modelo">Modelo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistMarcaId" id="marcaId" name="marcaId" autocomplete="off">
                                        <datalist id="datalistMarcaId">
                                            @foreach ($brandInventories as $brandInventorie)
                                            <option value="{{ $brandInventorie->id}} - {{$brandInventorie->descripcion}}">
                                                @endforeach
                                        </datalist>
                                        <label for="marcaId">Marca</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="potencia"
                                            name="potencia" required>
                                        <label for="potencia">Potencia</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistProveedorId" id="proveedorId"
                                            name="proveedorId">
                                        <datalist id="datalistProveedorId">
                                            @foreach ($thirds as $third)
                                            <option value="{{ $third->id}} - {{$third->nombre_completo}}">
                                                @endforeach
                                        </datalist>
                                        <label for="proveedorId">Proveedor</label>
                                    </div>
                                </div>
                                <div class="col-4 mt-3">
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="fecha_instalacion"
                                            name="fecha_instalacion" required>
                                        <label for="fecha_instalacion">Fecha de instalación</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="codigo"
                                            name="codigo" required>
                                        <label for="codigo">codigo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="number" class="form-control" id="horometro"
                                            name="horometro" required>
                                        <label for="horometro">Horometro</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="number" class="form-control" id="costo"
                                            name="costo" required>
                                        <label for="costo">Costo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <select class="form-select  mb-1" aria-label="mantenimientoLabel" id="mantenimiento" name="mantenimiento">
                                            <option value="#">seleccione mantenimiento</option>
                                            <option value="interno">Interno</option>
                                            <option value="externo">Externo</option>
                                            <option value="mixto">Mixto</option>
                                        </select>
                                        <label for="mantenimiento">mantenimiento</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <select class="form-select mb-1" aria-label="combustibleLabel" id="combustible" name="combustible">
                                            <option value="#">seleccione combustible</option>
                                            <option value="gasolina">Gasolina</option>
                                            <option value="diesel">Diesel</option>
                                        </select>
                                        <label for="combustible">combustible</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistUso_diario" id="uso_diario"
                                            name="uso_diario">
                                        <datalist id="datalistUso_diario">
                                            @foreach ($hours as $hour)
                                            <option value="{{ $hour->id}} - {{$hour->descripcion}}">
                                                @endforeach
                                        </datalist>
                                        <label for="uso_diario">Horario</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="file" class="form-control" name="ruta_imagen" id="ruta_imagen" />
                                        <label for="ruta_imagen"><strong>Foto</strong></label>
                                    </div>
                                </div>
                                <div class="col mt-3 text-center">
                                    <img id="imagenPrevisualizacion" src=""  class="img-thumbnail">
                                    <img>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pestaña2create">
                            <!--Contenido de la pestaña 2 -->
                            <div class="row">
                                <div class="col-6 mt-2">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="upm"
                                            name="upm" required>
                                        <label for="upm">UPM</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="area"
                                            name="area" required>
                                        <label for="area">Area</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="labor"
                                            name="labor" required>
                                        <label for="labor">Labor</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistAdministradorId" id="administradorId"
                                            name="administradorId">
                                        <datalist id="datalistAdministradorId">
                                            @foreach ($thirds as $third)
                                            <option value="{{ $third->id}} - {{$third->nombre_completo}}">
                                                @endforeach
                                        </datalist>
                                        <label for="administradorId">administrador</label>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistIngeniero" id="ingenieroId"
                                            name="ingenieroId">
                                        <datalist id="datalistIngeniero">
                                            @foreach ($thirds as $third)
                                            <option value="{{ $third->id}} - {{$third->nombre_completo}}">
                                                @endforeach
                                        </datalist>
                                        <label for="ingeniero">Ingeniero</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistJefe_mantenimiento_id" id="jefe_mantenimiento_id"
                                            name="jefe_mantenimiento_id">
                                        <datalist id="datalistJefe_mantenimiento_id">
                                            @foreach ($thirds as $third)
                                            <option value="{{ $third->id}} - {{$third->nombre_completo}}">
                                                @endforeach
                                        </datalist>
                                        <label for="jefe_mantenimiento_id">Jefe de mantenimiento</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistOperador_id" id="operador_id"
                                            name="operador_id">
                                        <datalist id="datalistOperador_id">
                                            @foreach ($thirds as $third)
                                            <option value="{{ $third->id}} - {{$third->nombre_completo}}">
                                                @endforeach
                                        </datalist>
                                        <label for="operador_id">Operador</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col ">
                                    <div class="form-floating">
                                        <textarea class="form-control" value="descripcion" name="descripcion"
                                            id="descripcion" style="height: 50px"></textarea>
                                        <label for="descripcion">descripción</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col ">
                                    <div class="form-floating">
                                        <textarea class="form-control" value="observaciones" name="observaciones"
                                            id="observaciones" style="height: 50px"></textarea>
                                        <label for="observaciones">Observaciones</label>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pestaña3create">
                            <!--Contenido de la pestaña 3 -->
                            <div class="container mt-3">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Pie del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSaveDevice">Guardar</button>
            </div>
        </div>
    </div>
</div>




<!-- Botón para abrir el modal -->
<div class="modal fade" tabindex="-1" id="updateDevice" aria-labelledby="updateDevicesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
    <!-- Modal -->
        <div class="modal-content">
        <!-- Cabecera del modal -->
            <div class="modal-header">
                <h4 class="modal-title">Gestión de equipos</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <!-- Navegación de pestañas -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" data-toggle="tab" href="#pestaña1update">Especificaciones generales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" aria-current="page" href="#pestaña2update">Especificaciones técnicas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" aria-current="page" href="#pestaña3update">Galería</a>
                    </li>
                </ul>
                <!-- Contenido de las pestañas -->
                <form action="" id="mainSpecsUpdate" class="form-control mt-3">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pestaña1update">
                            <!--Contenido de la pestaña 1 -->
                            <div class="row">
                                <div class="col-3 mt-3">
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="fecha_adquisicion"
                                            name="fecha_adquisicion" required>
                                        <label for="fecha_adquisicion">Fecha de adquisición</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistGrupo_equipo_id" id="grupo_equipo_id"
                                            name="grupo_equipo_id">
                                        <datalist id="datalistGrupo_equipo_id">
                                            @foreach ($fixedAssets as $fixedAsset)
                                            <option value="{{ $fixedAsset->id}} - {{$fixedAsset->descripcion}}">
                                                @endforeach
                                        </datalist>
                                        <label for="grupo_equipo_id">grupo de equipo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="serial_equipo"
                                            name="serial_equipo" required>
                                        <label for="serial_equipo">Serial equipo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="serial_interno"
                                            name="serial_interno" required>
                                        <label for="serial_interno">Serial interno</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="modelo"
                                            name="modelo" required>
                                        <label for="modelo">Modelo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistMarcaId" id="marcaId"
                                            name="marcaId">
                                        <datalist id="datalistMarcaId">
                                            @foreach ($brandInventories as $brandInventorie)
                                            <option value="{{ $brandInventorie->id}} - {{$brandInventorie->descripcion}}">
                                                @endforeach
                                        </datalist>
                                        <label for="marcaId">Marca</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="potencia"
                                            name="potencia" required>
                                        <label for="potencia">Potencia</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistProveedorId" id="proveedorId"
                                            name="proveedorId">
                                        <datalist id="datalistProveedorId">
                                            @foreach ($thirds as $third)
                                            <option value="{{ $third->id}} - {{$third->nombre_completo}}">
                                                @endforeach
                                        </datalist>
                                        <label for="proveedorId">Proveedor</label>
                                    </div>
                                </div>
                                <div class="col-4 mt-3">
                                    <div class="form-floating mb-1">
                                        <input type="date" class="form-control" id="fecha_instalacion"
                                            name="fecha_instalacion" required>
                                        <label for="fecha_instalacion">Fecha de instalación</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="codigo"
                                            name="codigo" required>
                                        <label for="codigo">codigo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="number" class="form-control" id="horometro"
                                            name="horometro" required>
                                        <label for="horometro">Horometro</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="number" class="form-control" id="costo"
                                            name="costo" required>
                                        <label for="costo">Costo</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <select class="form-select  mb-1" aria-label="mantenimientoLabel" id="mantenimiento" name="mantenimiento">
                                            <option value="#">seleccione mantenimiento</option>
                                            <option value="interno">Interno</option>
                                            <option value="externo">Externo</option>
                                            <option value="mixto">Mixto</option>
                                        </select>
                                        <label for="mantenimiento">mantenimiento</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <select class="form-select mb-1" aria-label="combustibleLabel" id="combustible" name="combustible">
                                            <option value="#">seleccione combustible</option>
                                            <option value="gasolina">Gasolina</option>
                                            <option value="diesel">Diesel</option>
                                        </select>
                                        <label for="combustible">combustible</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistUso_diario" id="uso_diario"
                                            name="uso_diario">
                                        <datalist id="datalistUso_diario">
                                            @foreach ($hours as $hour)
                                            <option value="{{ $hour->id}} - {{$hour->descripcion}}">
                                                @endforeach
                                        </datalist>
                                        <label for="uso_diario">Horario</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="file" class="form-control" name="ruta_imagen" id="ruta_imagen" />
                                        <label for="ruta_imagen"><strong>Foto</strong></label>
                                    </div>
                                </div>
                                <div class="col mt-3 text-center">
                                     <img id="imagenPrevisualizacion"
                                     src="data:image/jpeg;base64,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"
                                        class="img-thumbnail">
                                    <img>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pestaña2update">
                            <!--Contenido de la pestaña 2 -->
                            <div class="row">
                                <div class="col-6 mt-2">
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="upm"
                                            name="upm" required>
                                        <label for="upm">UPM</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="area"
                                            name="area" required>
                                        <label for="area">Area</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input type="text" class="form-control" id="labor"
                                            name="labor" required>
                                        <label for="labor">Labor</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistAdministradorId" id="administradorId"
                                            name="administradorId">
                                        <datalist id="datalistAdministradorId">
                                            @foreach ($thirds as $third)
                                            <option value="{{ $third->id}} - {{$third->nombre_completo}}">
                                                @endforeach
                                        </datalist>
                                        <label for="administradorId">administrador</label>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistIngeniero" id="ingeniero"
                                            name="ingeniero">
                                        <datalist id="datalistIngeniero">
                                            @foreach ($thirds as $third)
                                            <option value="{{ $third->id}} - {{$third->nombre_completo}}">
                                                @endforeach
                                        </datalist>
                                        <label for="ingeniero">Ingeniero</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistJefe_mantenimiento_id" id="jefe_mantenimiento_id"
                                            name="jefe_mantenimiento_id">
                                        <datalist id="datalistJefe_mantenimiento_id">
                                            @foreach ($thirds as $third)
                                            <option value="{{ $third->id}} - {{$third->nombre_completo}}">
                                                @endforeach
                                        </datalist>
                                        <label for="jefe_mantenimiento_id">Jefe de mantenimiento</label>
                                    </div>
                                    <div class="form-floating mb-1">
                                        <input class="form-control" list="datalistOperador_id" id="operador_id"
                                            name="operador_id">
                                        <datalist id="datalistOperador_id">
                                            @foreach ($thirds as $third)
                                            <option value="{{ $third->id}} - {{$third->nombre_completo}}">
                                                @endforeach
                                        </datalist>
                                        <label for="operador_id">Operador</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col ">
                                    <div class="form-floating">
                                        <textarea class="form-control" value="descripcion" name="descripcion"
                                            id="descripcion" style="height: 50px"></textarea>
                                        <label for="descripcion">descripción</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col ">
                                    <div class="form-floating">
                                        <textarea class="form-control" value="observaciones" name="observaciones"
                                            id="observaciones" style="height: 50px"></textarea>
                                        <label for="observaciones">Observaciones</label>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pestaña3update">
                            <!--Contenido de la pestaña 3 -->
                            <div class="container mt-3">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Pie del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnUpdateDevice">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div id="deleteDevice" class="modal fade" tabindex="-1" aria-labelledby="deleteDeviceLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el equipo?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteDevice" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

