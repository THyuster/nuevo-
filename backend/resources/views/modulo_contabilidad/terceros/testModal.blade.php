<!-- Botón para abrir el modal -->
<div class="modal fade" tabindex="-1" id="modalExample" aria-labelledby="thirdPartiesLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
  
  <!-- Modal -->
  {{-- <div class="modal-xl modal fade" tabindex="-1"" id="modalExample" aria-hidden="true"> --}}
    {{-- <div class="modal-dialog"> --}}
      <div class="modal-content">
      
        <!-- Cabecera del modal -->
        <div class="modal-header">
          <h4 class="modal-title">Mi Modal con Navegación de Pestañas</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
        </div>
        
        <!-- Cuerpo del modal -->
        <div class="modal-body">
        
          <!-- Navegación de pestañas -->
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#pestaña1">Información básica</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#pestaña2">Referencias personales</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#pestaña3">Galería</a>
            </li>
          </ul>
          
          <!-- Contenido de las pestañas -->
          <div class="tab-content">
            <div class="tab-pane fade show active" id="pestaña1">
              {{-- Contenido de la pestaña 1 --}}
                <div class="container">
                <form class="form-horizontal" id="formExtenseData" role="form" accept-charset="UTF-8"
                    enctype="multipart/form-data">
                    <div class="container ">
                        <div class="row gx-3">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="naturaleza_juridica" name="naturaleza_juridica"
                                        aria-label="Naturaleza Juridica">
                                        <option value="0" selected>Seleccione</option>
                                        <option value="Jurídica">Jurídica</option>
                                        <option value="Natural">Natural</option>
                                    </select>
                                    <label for="naturaleza_juridica"><strong>Naturaleza Juridica</strong></label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="fecha_inactivo"
                                        name="fecha_inactivo" value="2022-05-20">
                                    <label for="fecha_inactivo"><strong>Fecha inactivo</strong></label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="fecha_actualizacion"
                                        name="fecha_actualizacion" disabled>
                                    <label for="fecha_actualizacion">Fecha Actualización</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container ">
                        <div class="row gx-3">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input class="form-control" list="datalistOptions" id="tipo_identificacion" placeholder="tipo de identificación">
                                    <datalist id="datalistOptions">
                                        @foreach ($typesIdentifications as $typesIdentification)
                                        <option value="{{ $typesIdentification->id}} - {{$typesIdentification->descripcion}}">
                                        @endforeach
                                    </datalist>
                                    <label for="identificacion">tipo Identificación</label>
                                </div>
                                {{-- <div class="form-floating mb-3">
                                    <select class="form-select" id="tipo_identificacion" name="tipo_identificacion"
                                        aria-label="tipo identificacion" required>
                                        @foreach ($typesIdentifications as $typesIdentification)
                                        <option value="{{ $typesIdentification->id}}">
                                            {{$typesIdentification->descripcion}}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="tipo_identificacion"><strong>Tipo de Identificacion</strong></label>
                                </div> --}}
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="identificacion"
                                        name="identificacion" required>
                                    <label for="identificacion">Numero Identificación</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="digito_verificacion"
                                        name="digito_verificacion">
                                    <label for="digito_verificacion">DV</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" name="grupo_sanguineo" class="form-control"
                                        id="grupo_sanguineo">
                                    <label for="grupo_sanguineo">RH</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container ">
                        <div class="row gx-3">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="apellido1" name="apellido1"
                                        required>
                                    <label for="apellido1">Primer Apellido</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="apellido2" name="apellido2"
                                        required>
                                    <label for="apellido2">Segundo Apellido</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="nombre1" name="nombre1" required>
                                    <label for="nombre1">Primer Nombre</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" name="nombre2" class="form-control" id="nombre2">
                                    <label for="nombre2">Segundo Nombre</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row row-cols-2 row-cols-lg-3 g-2 g-lg-3">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" value="Av3#15" name="direccion" class="form-control"
                                        id="direccion" required>
                                    <label for="direccion">Dirección</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" class="form-control" id="email" required>
                                    <label for="email">Correo Electronico</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="number" name="telefono_fijo" class="form-control"
                                        id="telefono_fijo">
                                    <label for="telefono_fijo">Telefono Fijo</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="municipio" name="municipio"
                                        aria-label="municipio">
                                        @foreach ($municipalitys as $municipality)
                                        <option value="{{ $municipality->id}}">
                                            {{$municipality->descripcion}}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="municipio"><strong>Tipo Municipio</strong></label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control is-required" name="movil" id="movil">
                                    <label for="movil">Número de Celular</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="fecha_nacimiento"
                                        name="fecha_nacimiento" value="2000-05-20">
                                    <label for="fecha_nacimiento" style="text-transform: uppercase;"><strong>Fecha
                                            Nacimiento</strong></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-2" style="max-height: 120px; overflow-y: auto;">
                                <div class="input-group" id="checkedInput">
                                    @foreach($typesThirds as $tiposTercero)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="tipo_tercero" name="tipo_tercero"
                                            value="{{$tiposTercero->id}}">
                                        <label class="form-check-label"
                                            for="tipo_tercero">{{$tiposTercero->descripcion}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating">
                                    <textarea class="form-control" value="observacion" name="observacion"
                                        id="observacion" style="height: 120px"></textarea>
                                    <label for="observacion">Observaciones</label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-floating mb-0">
                                    <input type="file" class="form-control" name="image" id="image" />
                                    <label for="image"><strong>Foto</strong></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
              </div>
            </div>



            <div class="tab-pane fade" id="pestaña2">
              {{-- Contenido de la pestaña 2 --}}
                <!-- checkbox -->

            </div>
            <div class="tab-pane fade" id="pestaña3">
              {{-- Contenido de la pestaña 3 --}}
              No es broma
            </div>
          </div>
          
        </div>
        
        <!-- Pie del modal -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary">Guardar</button>
        </div>
        
      </div>
    </div>
  </div>

  <div class="modal modal-fade"></div>