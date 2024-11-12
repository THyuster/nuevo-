{{-- modal formulario --}}
<div class="modal fade" tabindex="-1" id="thirdParty" aria-labelledby="thirdPartiesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Creación de terceros</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-group">
                <ul class="nav nav-tabs mb-3 mx-4">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#pestaña1create">Información básica</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#pestaña2create">Referencias personales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#pestaña3create">Galería</a>
                    </li>
                </ul>
                <div class="tab-content">
                    {{-- Contenido de la primera pestaña --}}
                    <div class="tab-pane fade show active" id="pestaña1create">
                        <div class="container">
                            <form class="form-horizontal" id="formExtenseData" role="form" accept-charset="UTF-8"
                                enctype="multipart/form-data">
                                <div class="container ">
                                    <div class="row gx-3">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" id="naturaleza_juridica"
                                                    name="naturaleza_juridica" aria-label="Naturaleza Juridica"
                                                    required>
                                                    <option value="Natural">Natural</option>
                                                    <option value="Jurídica">Jurídica</option>
                                                </select>
                                                <label for="naturaleza_juridica"><strong>Naturaleza
                                                        Juridica</strong></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" id="fecha_inactivo"
                                                    name="fecha_inactivo" value="" disabled>
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
                                                <select class="form-select" id="tipo_identificacion"
                                                    name="tipo_identificacion" aria-label="tipo identificacion"
                                                    required>
                                                    @foreach ($typesIdentifications as $typesIdentification)
                                                        <option value="{{ $typesIdentification->id }}">
                                                            {{ $typesIdentification->descripcion }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="tipo_identificacion"><strong>Tipo de
                                                        Identificacion</strong></label>
                                            </div>
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
                                                <input type="text" class="form-control" id="DV"
                                                    name="DV">
                                                <label for="DV">DV</label>
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
                                                <input type="text" class="form-control" id="apellido1"
                                                    name="apellido1" required>
                                                <label for="apellido1">Primer Apellido</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="apellido2"
                                                    name="apellido2" required>
                                                <label for="apellido2">Segundo Apellido</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="nombre1"
                                                    name="nombre1" required>
                                                <label for="nombre1">Primer Nombre</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="nombre2" class="form-control"
                                                    id="nombre2">
                                                <label for="nombre2">Segundo Nombre</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row row-cols-2 row-cols-lg-3 g-2 g-lg-3">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="email" name="email" class="form-control"
                                                    id="email" required>
                                                <label for="email">Correo Electronico</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control is-required" name="movil"
                                                    id="movil">
                                                <label for="movil">Número de Celular</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" name="direccion" class="form-control"
                                                    id="direccion" required>
                                                <label for="direccion">Dirección</label>
                                            </div>
                                            <div class="col-2" style="max-height: 36%; overflow-y: auto; width:50%">
                                                <div class="input-group" id="checkedInput">
                                                    @foreach ($typesThirds as $tiposTercero)
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="tipo_tercero"
                                                                type="checkbox" id="tipo_tercero"
                                                                value="{{ $tiposTercero->id }}">
                                                            <label class="form-check-label"
                                                                for="tipo_tercero">{{ $tiposTercero->descripcion }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" id="fecha_nacimiento"
                                                    name="fecha_nacimiento" value="2000-05-20">
                                                <label for="fecha_nacimiento"
                                                    style="text-transform: uppercase;"><strong>Fecha
                                                        Nacimiento</strong></label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="number" name="telefono_fijo" class="form-control"
                                                    id="telefono_fijo">
                                                <label for="telefono_fijo">Telefono Fijo</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" list="datalistMunicipio" id="municipio"
                                                    name="municipio" placeholder="Municipio" autocomplete="off">
                                                <datalist id="datalistMunicipio">
                                                    @foreach ($municipalitys as $municipality)
                                                        <option
                                                            value="{{ $municipality->id }} - {{ $municipality->descripcion }}">
                                                    @endforeach
                                                </datalist>
                                                <label for="municipio">Tipo Municipio</label>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-floating">
                                                    <textarea class="form-control" value="observacion" name="observacion" id="observacion"
                                                        style="width: 200%; height: 150px;"></textarea>
                                                    <label for="observacion">Observaciones</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-4">
                                            <div class="form-floating pb-3">
                                                <input type="file" class="form-control" name="ruta_imagen"
                                                    id="ruta_imagen">
                                                <label for="ruta_imagen"><strong>Foto</strong></label>
                                            </div>
                                            <img id="imagenPrevisualizacion"
                                                src="http://181.48.57.46:8083/imagenes/Sgju118SpEmmjMjy0n6pHmhKhmnNaWpPQoUHw2oGio4In60Le5F82SGDioQ2dHyKN6JUp1tIPyRz1jYYNZLJQlEDeSYOU2JZe21ysZu3JHSDESmY17dNyfYI.png"
                                                class="img-thumbnail" style="width:200%; height: 73%;">
                                            <img>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- Contenido de la segunda pestaña  --}}
                    <div class="tab-pane fade" id="pestaña2create">
                        <div class="container my-5"></div>
                    </div>
                    {{-- Contenido de la tercera pestaña --}}
                    <div class="tab-pane fade" id="pestaña3create">
                        <div class="container my-5"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Cancelar</button>
                <button id="btnConfirmThirdParty" type="submit" form="formExtenseData"
                    class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

{{-- modal formulario edición --}}
<div class="modal fade" tabindex="-1" id="thirdPartyEdit" aria-labelledby="thirdPartyEditLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edición de terceros</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-group">
                <ul class="nav nav-tabs mb-3 mx-4">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#pestaña1edit">Información básica</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#pestaña2edit">Referencias personales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#pestaña3edit">Galería</a>
                    </li>
                </ul>
                <div class="tab-content">
                    {{-- Contenido de la primera pestaña --}}
                    <div class="tab-pane fade show active" id="pestaña1edit">
                        <div class="container">
                            <form class="form-horizontal" id="formExtenseDataUpdate" role="form"
                                accept-charset="UTF-8" enctype="multipart/form-data">
                                <div class="container ">
                                    <div class="row gx-3">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" id="naturaleza_juridica"
                                                    name="naturaleza_juridica" aria-label="Naturaleza Juridica"
                                                    required>
                                                    <option value="Natural">Natural</option>
                                                    <option value="Jurídica">Jurídica</option>
                                                </select>
                                                <label for="naturaleza_juridica"><strong>Naturaleza
                                                        Juridica</strong></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" id="fecha_inactivo"
                                                    name="fecha_inactivo" value="" disabled>
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
                                                <select class="form-select" id="tipo_identificacion"
                                                    name="tipo_identificacion" aria-label="tipo identificacion"
                                                    required>
                                                    @foreach ($typesIdentifications as $typesIdentification)
                                                        <option value="{{ $typesIdentification->id }}">
                                                            {{ $typesIdentification->descripcion }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="tipo_identificacion"><strong>Tipo de
                                                        Identificacion</strong></label>
                                            </div>
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
                                                <input type="text" class="form-control" id="DV"
                                                    name="DV">
                                                <label for="DV">DV</label>
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
                                                <input type="text" class="form-control" id="apellido1"
                                                    name="apellido1" required>
                                                <label for="apellido1">Primer Apellido</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="apellido2"
                                                    name="apellido2" required>
                                                <label for="apellido2">Segundo Apellido</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="nombre1"
                                                    name="nombre1" required>
                                                <label for="nombre1">Primer Nombre</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="nombre2" class="form-control"
                                                    id="nombre2">
                                                <label for="nombre2">Segundo Nombre</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row row-cols-2 row-cols-lg-3 g-2 g-lg-3">
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="email" name="email" class="form-control"
                                                    id="email" required>
                                                <label for="email">Correo Electronico</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control is-required" name="movil"
                                                    id="movil">
                                                <label for="movil">Número de Celular</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" name="direccion" class="form-control"
                                                    id="direccion" required>
                                                <label for="direccion">Dirección</label>
                                            </div>
                                            <div class="col-2 px-3"
                                                style="max-height: 36%; overflow-y:auto; width:50%; ">
                                                <div class="input-group " id="checkedInput">
                                                    @foreach ($typesThirds as $tiposTercero)
                                                        <div class="form-check pr-3">
                                                            <input class="form-check-input" name="tipo_tercero"
                                                                type="checkbox" id="tipo_tercero"
                                                                value="{{ $tiposTercero->id }}">
                                                            <label class="form-check-label"
                                                                for="tipo_tercero">{{ $tiposTercero->descripcion }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" id="fecha_nacimiento"
                                                    name="fecha_nacimiento" value="2000-05-20">
                                                <label for="fecha_nacimiento"
                                                    style="text-transform: uppercase;"><strong>Fecha
                                                        Nacimiento</strong></label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="number" name="telefono_fijo" class="form-control"
                                                    id="telefono_fijo">
                                                <label for="telefono_fijo">Telefono Fijo</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" list="datalistMunicipio" id="municipio"
                                                    name="municipio" placeholder="Municipio" autocomplete="off">
                                                <datalist id="datalistMunicipio">
                                                    @foreach ($municipalitys as $municipality)
                                                        <option
                                                            value="{{ $municipality->id }} - {{ $municipality->descripcion }}">
                                                    @endforeach
                                                </datalist>
                                                <label for="municipio">Tipo Municipio</label>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-floating">
                                                    <textarea class="form-control" value="observacion" name="observacion" id="observacion"
                                                        style="width: 200%; height: 150px;"></textarea>
                                                    <label for="observacion">Observaciones</label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-4">
                                            <div class="form-floating pb-3">
                                                <input type="file" class="form-control" name="ruta_imagen"
                                                    id="ruta_imagen">
                                                <label for="ruta_imagen"><strong>Foto</strong></label>
                                            </div>
                                            <img id="imagenPrevisualizacion"
                                                src="http://181.48.57.46:8083/imagenes/Sgju118SpEmmjMjy0n6pHmhKhmnNaWpPQoUHw2oGio4In60Le5F82SGDioQ2dHyKN6JUp1tIPyRz1jYYNZLJQlEDeSYOU2JZe21ysZu3JHSDESmY17dNyfYI.png"
                                                class="img-thumbnail" style="width:200%; height: 73%;">
                                            <img>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- Contenido de la segunda pestaña  --}}
                    <div class="tab-pane fade" id="pestaña2edit">
                        <div class="container my-5"></div>
                    </div>
                    {{-- Contenido de la tercera pestaña --}}
                    <div class="tab-pane fade" id="pestaña3edit">
                        <div class="container my-5"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Cancelar</button>
                <button id="btnThirdPartyEdit" type="submit" form="formExtenseData"
                    class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>


{{-- <div class="modal fade" tabindex="-1" id="thirdPartyEdit" aria-labelledby="thirdPartiesEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edición de terceros</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-group">
                <ul class="nav nav-tabs mb-3 mx-4" >
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#pestaña1edit">Información básica</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#pestaña2edit">Referencias personales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#pestaña3edit">Galería</a>
                    </li>
                </ul>
                <div class="tab-content">
                <div class="tab-pane fade" id="pestaña1edit">
                <div class="container">
                    <form class="form-horizontal" id="formExtenseDataUpdate" role="form" accept-charset="UTF-8"
                        enctype="multipart/form-data">
                        <div class="container ">
                            <div class="row gx-3">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="naturaleza_juridica" name="naturaleza_juridica"
                                            aria-label="Naturaleza Juridica">
                                            <option value="0">Seleccione</option>
                                            <option value="Jurídica">Jurídica</option>
                                            <option value="Natural" selected>Natural</option>
                                        </select>
                                        <label for="naturaleza_juridica">
                                            <strong>Naturaleza Juridica</strong></label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="fecha_inactivo"
                                            name="fecha_inactivo">
                                        <label for="fecha_inactivo">
                                            <strong>Fecha inactivo</strong></label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="fecha_actualizacion"
                                            name="fecha_actualizacion">
                                        <label for="fecha_actualizacion">Fecha Actualización</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container ">
                            <div class="row gx-3">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="tipo_identificacion" name="tipo_identificacion"
                                            aria-label="tipo identificacion">
                                            @foreach ($typesIdentifications as $typesIdentification)
                                            <option value="{{ $typesIdentification->id}}">
{{$typesIdentification->descripcion}}
</option>
@endforeach
</select>
<label for="tipo_identificacion"><strong>Tipo
        Identificacion</strong></label>
</div>
</div>
<div class="col">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="identificacion" name="identificacion" required>
        <label for="identificacion">Numero Identificación</label>
    </div>
</div>

<div class="col">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="DV" name="DV">
        <label for="DV">DV</label>
    </div>

</div>

<div class="col">
    <div class="form-floating mb-3">
        <input type="text" name="grupo_sanguineo" class="form-control" id="grupo_sanguineo">
        <label for="grupo_sanguineo">RH</label>
    </div>
</div>
</div>
</div>

<div class="container ">
    <div class="row gx-3">
        <div class="col">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="apellido1" name="apellido1" required>
                <label for="apellido1">Primer Apellido</label>
            </div>
        </div>
        <div class="col">
            <div class="form-floating mb-3">
                <input type="text" name="apellido2" class="form-control" id="apellido2" placeholder="Suarez" required>
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
                <input type="email" name="email" class="form-control" id="email" required>
                <label for="email">Correo Electronico</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" class="form-control is-required" name="movil" id="movil">
                <label for="movil">Número de Celular</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="direccion" class="form-control" id="direccion" required>
                <label for="direccion">Dirección</label>
            </div>
            <div class="col-2 px-3" style="max-height: 36%; overflow-y:auto; width:50%; ">
                <div class="input-group " id="checkedInput">
                    @foreach ($typesThirds as $tiposTercero)
                    <div class="form-check pr-3">
                        <input class="form-check-input" name="tipo_tercero{{$tiposTercero->id}}" type="checkbox" id="tipo_tercero{{$tiposTercero->id}}" value="{{$tiposTercero->id}}">
                        <label class="form-check-label" for="tipo_tercero{{$tiposTercero->id}}">{{$tiposTercero->descripcion}}</label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col">
            <div class="form-floating mb-3">
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="2000-05-20">
                <label for="fecha_nacimiento" style="text-transform: uppercase;"><strong>Fecha
                        Nacimiento</strong></label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" name="telefono_fijo" class="form-control" id="telefono_fijo">
                <label for="telefono_fijo">Telefono Fijo</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" list="datalistMunicipio" id="municipio" name="municipio" placeholder="Municipio" autocomplete="off">
                <datalist id="datalistMunicipio">
                    @foreach ($municipalitys as $municipality)
                    <option value="{{ $municipality->id}} - {{$municipality->descripcion}}">
                        @endforeach
                </datalist>
                <label for="municipio">Tipo Municipio</label>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <textarea class="form-control" value="observacion" name="observacion" id="observacion" style="width: 200%; height: 150px; "></textarea>
                    <label for="observacion">Observaciones</label>
                </div>
            </div>

        </div>
        <div class="col-4">
            <div class="form-floating pb-3">
                <input type="file" class="form-control" name="ruta_imagen" id="ruta_imagen">
                <label for="ruta_imagen"><strong>Foto</strong></label>
            </div>
            <img id="imagenPrevisualizacion" src="http://181.48.57.46:8083/imagenes/Sgju118SpEmmjMjy0n6pHmhKhmnNaWpPQoUHw2oGio4In60Le5F82SGDioQ2dHyKN6JUp1tIPyRz1jYYNZLJQlEDeSYOU2JZe21ysZu3JHSDESmY17dNyfYI.png" class="img-thumbnail" style="width:200%; height:73%;">
            <img>
        </div>
    </div>
</div>

</form>
</div>
</div>
<div class="tab-pane fade" id="pestaña2edit">
    <div class="container my-5"></div>
</div>
<div class="tab-pane fade" id="pestaña3edit">
    <div class="container my-5"></div>
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Cancelar</button>
    <button id="btnThirdPartyEdit" type="submit" form="formExtenseDataUpdate" class="btn btn-primary">Guardar</button>
</div>
</div>
</div>
</div> --}}

<div id="deleteThird" class="modal fade" tabindex="-1" aria-labelledby="deleteThirdLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el tercero?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteThird" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>
