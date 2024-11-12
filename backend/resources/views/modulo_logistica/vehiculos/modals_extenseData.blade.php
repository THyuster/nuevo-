{{-- modal formulario--}}
<div class="modal fade" tabindex="-1" id="ArticuloCreate" aria-labelledby="modalArticuloCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0">
                <!-- <h4 class="modal-title"></h4> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-group">
                <div class="container">
                    <form id="formArticuloCreacion" onsubmit="return false;">
                        <div class="row g-2">
                            <div class="col-3">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" class="form-control" id="codigo" name="codigo">
                                    <label for="codigo">Código</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="descripcion" class="form-control"
                                        id="descripcion">
                                    <label for="descripcion">Descripción Artículo</label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="fecha_modificacion"
                                        name="fecha_modificacion" placeholder="20/05/2000" value="">
                                    <label for="fecha_modificacion" style="text-transform: uppercase;">
                                        <strong>Fecha Actualización</strong></label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="codigo_contable" name="codigo_contable"
                                        aria-label="Grupo contable">
                                        <option value="0" selected>Seleccione</option>
                                        @foreach ($ModelGrupoContable as $GrupoContable)
                                        <option value="{{ $GrupoContable->id}}">
                                            {{$GrupoContable->descripcion}}</option>
                                        @endforeach
                                    </select>
                                    <label for="codigo_contable">Grupo contable</label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="grupo_articulo" name="grupo_articulo"
                                        aria-label="Grupo Articulo">
                                        <option value="0" selected>Seleccione</option>
                                        @foreach ($ModelGrupoArticulo as $GrupoArticulo)
                                        <option value="{{ $GrupoArticulo->id}}">
                                            {{$GrupoArticulo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                    <label for="grupo_articulo">Grupo Articulo</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="tipo_articulo_id" name="tipo_articulo_id"
                                        aria-label="Tipo Articulo">
                                        <option value="0" selected>Seleccione</option>
                                        @foreach ($ModelTipoArticulo as $TipoArticulo)
                                        <option value="{{ $TipoArticulo->id}}">
                                            {{$TipoArticulo->descripcion}}</option>
                                        @endforeach
                                    </select>
                                    <label for="tipo_articulo_id">Tipo artículo</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="unidad_id" name="unidad_id" aria-label="Unidad">
                                        <option value="0" selected>Seleccione</option>
                                        @foreach ($ModelUnidad as $Unidad)
                                        <option value="{{ $Unidad->id}}">
                                            {{$Unidad->descripcion}}</option>
                                        @endforeach
                                    </select>
                                    <label for="unidad_id">Unidad</label>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="marca_id" name="marca_id" aria-label="Marca">
                                        <option value="0" selected>Seleccione</option>
                                        @foreach ($ModelMarca as $Marca)
                                        <option value="{{ $Marca->id}}">
                                            {{$Marca->descripcion}}</option>
                                        @endforeach
                                    </select>
                                    <label for="marca_id">Marca</label>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" class="form-control" name="existencia_minima"
                                        id="existencia_minima">
                                    <label for="existencia_minima">Existencia Mínima</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="existencia_maxima" class="form-control"
                                        id="existencia_maxima">
                                    <label for="floatingMaxExistence">Existencia Máxima</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="precio_promedio" class="form-control"
                                        id="precio_promedio">
                                    <label for="precio_promedio">Precio Promedio</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="ultimo_precio" class="form-control"
                                        id="ultimo_precio">
                                    <label for="ultimo_precio">Ultimo Precio</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-floating mb-1">
                                    <input type="file" class="form-control" name="ruta_foto" id="ruta_foto" />
                                    <label for="floatingFoto" style="text-transform: uppercase;"><strong>
                                            FOTO</strong></label>

                                </div>
                            </div>
                        </div>
                        <div class="container mb-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="observaciones" name="observaciones"
                                            id="observaciones" style="height: 230px"></textarea>
                                        <label for="observaciones">Observaciones</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <img id="imagenPrevisualizacion"
                                        src="https://images.pexels.com/photos/733872/pexels-photo-733872.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
                                        class="img-thumbnail">
                                    <img>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Cancelar</button>
                <button id="btnArticuloCreate" type="button"
                    class="btn btn-primary">Confirmar</button>
            </div>

        </div>
    </div>
</div>