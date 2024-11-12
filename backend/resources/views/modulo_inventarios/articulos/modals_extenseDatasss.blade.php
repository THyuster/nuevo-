{{-- modal formulario--}}
<div class="modal fade" tabindex="-1" id="ArticuloCreate" aria-labelledby="modalArticuloCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h4 class="modal-title"> Creación de artículo</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-group">
                <div class="container">
                    <form id="formArticuloCreacion" enctype="multipart/form-data" onsubmit="return false;">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="codigo" name="codigo" required>
                                    <label for="codigo">Código</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="descripcion" class="form-control" id="descripcion">
                                    <label for="descripcion">Descripción Artículo</label>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input class="form-control" list="datalistOptions" name="grupo_contable_id" id="grupo_contable_id" autocomplete="off">
                                    <datalist id="datalistOptions">
                                        @foreach ($ModelGrupoContable as $GrupoContable)
                                        <option value="{{ $GrupoContable->id}} - {{$GrupoContable->descripcion}}">
                                            @endforeach
                                    </datalist>
                                    <label for="grupo_contable_id">Grupo contable</label>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-floating mb-3">
                                    <input class="form-control" list="datalistGrupoArticulo" name="grupo_articulo_id" id="grupo_articulo_id" autocomplete="off">
                                    <datalist id="datalistGrupoArticulo">
                                        @foreach ($ModelGrupoArticulo as $GrupoArticulo)
                                        <option value="{{ $GrupoArticulo->id}} - {{$GrupoArticulo->descripcion}}">
                                            @endforeach
                                    </datalist>
                                    <label for="grupo_articulo_id">Grupo Articulo</label>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input class="form-control" list="datalistTipoArticulo" name="tipo_articulo_id" id="tipo_articulo_id">
                                    <datalist id="datalistTipoArticulo">
                                        @foreach ($ModelTipoArticulo as $TipoArticulo)
                                        <option value="{{ $TipoArticulo->id}} - {{$TipoArticulo->descripcion}}">
                                            @endforeach
                                    </datalist>
                                    <label for="tipo_articulo_id">Tipo artículo</label>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input class="form-control" list="datalistUnidad" name="unidad_id" id="unidad_id" autocomplete="off">
                                    <datalist id="datalistUnidad">
                                        @foreach ($ModelUnidad as $Unidad)
                                        <option value="{{ $Unidad->id}} - {{$Unidad->descripcion}}">
                                            @endforeach
                                    </datalist>
                                    <label for="unidad_id">Unidad</label>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-floating mb-3">

                                    <input class="form-control" list="marca_lista" id="marca_id" name="marca_id">

                                    <datalist id="marca_lista">
                                        @foreach ($ModelMarca as $Marca)
                                        <option value="{{$Marca->id}} - {{$Marca->descripcion}}">
                                            @endforeach
                                    </datalist>

                                    <label for="marca_id">Marca</label>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" class="form-control" name="existencia_minima" id="existencia_minima">
                                    <label for="existencia_minima">Existencia Mínima</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="existencia_maxima" class="form-control" id="existencia_maxima">
                                    <label for="existencia_maxima">Existencia Máxima</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="precio_promedio" class="form-control" id="precio_promedio">
                                    <label for="precio_promedio">Precio Promedio</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="ultimo_precio" class="form-control" id="ultimo_precio">
                                    <label for="ultimo_precio">Ultimo Precio</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-floating mb-1">
                                    <input type="file" class="form-control" name="ruta_imagen" id="ruta_imagen" />
                                    <label for="ruta_imagen" style="text-transform: uppercase;"><strong>FOTO</strong></label>
                                </div>
                            </div>
                        </div>
                        <div class="container mb-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="observaciones" name="observaciones" id="observaciones" style="height: 230px"></textarea>
                                        <label for="observaciones">Observaciones</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <img id="imagenPrevisualizacion" src="
                                    http://181.48.57.46:8083/imagenes/Sgju118SpEmmjMjy0n6pHmhKhmnNaWpPQoUHw2oGio4In60Le5F82SGDioQ2dHyKN6JUp1tIPyRz1jYYNZLJQlEDeSYOU2JZe21ysZu3JHSDESmY17dNyfYI.png
                                    " class="img-thumbnail rounded-0">
                                    <img>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnArticuloCreate" type="button" form="formArticuloCreacion" class="btn btn-primary">Confirmar</button>
            </div>

        </div>
    </div>
</div>

{{-- modal formulario--}}
<div class="modal fade" tabindex="-1" id="ArticuloEdit" aria-labelledby="modalArticuloCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-group">
                <div class="container">
                    <form id="formArticuloEdit" enctype="multipart/form-data" onsubmit="return false;">
                        <div class="row g-2">
                            <div class="col-3">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="codigo" name="codigo" required>
                                    <label for="codigo">Código</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="descripcion" class="form-control" id="descripcion">
                                    <label for="descripcion">Descripción Artículo</label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="fecha_modificacion" name="fecha_modificacion" disabled>
                                    <label for="fecha_modificacion" style="text-transform: uppercase;">
                                        <strong>Fecha Actualización</strong></label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input class="form-control" list="datalistOptions" name="grupo_contable_id" id="grupo_contable_id" placeholder="Grupo contable" autocomplete="off">
                                    <datalist id="datalistOptions">
                                        @foreach ($ModelGrupoContable as $GrupoContable)
                                        <option value="{{ $GrupoContable->id}} - {{$GrupoContable->descripcion}}">
                                            @endforeach
                                    </datalist>
                                    <label for="grupo_contable_id">Grupo contable</label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-floating mb-3">
                                    <input class="form-control" list="datalistGrupoArticulo" name="grupo_articulo_id" id="grupo_articulo_id" placeholder="Grupo de articulo" autocomplete="off">
                                    <datalist id="datalistGrupoArticulo">
                                        @foreach ($ModelGrupoArticulo as $GrupoArticulo)
                                        <option value="{{ $GrupoArticulo->id}} - {{$GrupoArticulo->descripcion}}">
                                            @endforeach
                                    </datalist>
                                    <label for="grupo_articulo_id">Grupo Articulo</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input class="form-control" list="datalistTipoArticulo" name="tipo_articulo_id" id="tipo_articulo_id" placeholder="Tipo de articulo" autocomplete="off">
                                    <datalist id="datalistTipoArticulo">
                                        @foreach ($ModelTipoArticulo as $TipoArticulo)
                                        <option value="{{ $TipoArticulo->id}} - {{$TipoArticulo->descripcion}}">
                                            @endforeach
                                    </datalist>
                                    <label for="tipo_articulo_id">Tipo artículo</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input class="form-control" list="datalistUnidad" name="unidad_id" id="unidad_id" placeholder="Unidad" autocomplete="off">
                                    <datalist id="datalistUnidad">
                                        @foreach ($ModelUnidad as $Unidad)
                                        <option value="{{ $Unidad->id}} - {{$Unidad->descripcion}}">
                                            @endforeach
                                    </datalist>
                                    <label for="unidad_id">Unidad</label>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-floating mb-3">
                                    <input class="form-control" list="datalistMarca" id="marca_id" name="marca_id" placeholder="Marca" autocomplete="off">
                                    <datalist id="datalistMarca">
                                        @foreach ($ModelMarca as $Marca)
                                        <option value="{{ $Marca->id}} - {{$Marca->descripcion}}">
                                            @endforeach
                                    </datalist>
                                    <label for="marca_id">Marca</label>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" class="form-control" name="existencia_minima" id="existencia_minima">
                                    <label for="existencia_minima">Existencia Mínima</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="existencia_maxima" class="form-control" id="existencia_maxima">
                                    <label for="existencia_maxima">Existencia Máxima</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="precio_promedio" class="form-control" id="precio_promedio">
                                    <label for="precio_promedio">Precio Promedio</label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="ultimo_precio" class="form-control" id="ultimo_precio">
                                    <label for="ultimo_precio">Ultimo Precio</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-floating mb-1">
                                    <input type="file" class="form-control" name="ruta_imagen" id="ruta_imagen" />
                                    <label for="ruta_imagen" style="text-transform: uppercase;"><strong>FOTO</strong></label>
                                </div>
                            </div>
                        </div>
                        <div class="container mb-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="observaciones" name="observaciones" id="observaciones" style="height: 230px"></textarea>
                                        <label for="observaciones">Observaciones</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <img id="imagenPrevisualizacion" src="https://images.pexels.com/photos/733872/pexels-photo-733872.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-thumbnail">
                                    <img>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="btnArticuloEdit" type="button" form="formArticuloCreacion" class="btn btn-primary">Confirmar</button>
            </div>

        </div>
    </div>
</div>