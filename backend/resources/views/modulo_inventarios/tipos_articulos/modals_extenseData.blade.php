{{-- modal formulario--}}
<div class="modal fade" tabindex="-1" id="article_type" aria-labelledby="thirdPartiesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                        <h4 >Gestión de Artículos</h4>
                        <span class="ms-5">Fecha de Modificación: <strong>4 de Julio de 2023</strong></span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-group">
                <form action="">
                    <div class="container">
                        <div class="row g-2">
                        <div class="col-3">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" class="form-control" id="CodeArticle">
                                    <label for="floatingCodeArticle">Código</label>
                                </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating mb-3">
                                <input type="text" value="" class="form-control" id="descriptionArticle">
                                <label for="floatingDescriptionArticle">Descripción Artículo</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="floatingselectAccountGroup"
                                    aria-label="Grupo contable">
                                    <option value="0" >Activo</option>
                                    <option value="1">Inactivo</option>
                                </select>
                                <label for="floatingselectAccountGroup">Estado</label>
                            </div>
                        </div>
                        {{--segunda fila--}}
                        <div class="col-2">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="floatingselectAccountGroup"
                                    aria-label="Grupo contable">
                                    <option value="0" >Activo</option>
                                    <option value="1">Inactivo</option>
                                </select>
                                <label for="floatingselectAccountGroup">Grupo contable</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="floatingselectArticleGroup"
                                    aria-label="Grupo Articulo">
                                    <option value="0" >Activo</option>
                                    <option value="1">Inactivo</option>
                                </select>
                                <label for="floatingselectAccountGroup">Grupo Articulo</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="floatingselectArticleType"
                                    aria-label="Tipo Articulo">
                                    <option value="0" >Activo</option>
                                    <option value="1">Inactivo</option>
                                </select>
                                <label for="floatingselectArticleType">Tipo artículo</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="floatingselectUnit" aria-label="Unidad">
                                    <option value="0" >Activo</option>
                                    <option value="1">Inactivo</option>
                                </select>
                                <label for="floatingselectArticleType">Unidad</label>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="floatingselectBrand" aria-label="Marca">
                                    <option value="0" >Activo</option>
                                    <option value="1">Inactivo</option>
                                </select>
                                <label for="floatingselectArticleType">Marca</label>
                            </div>
                        </div>
{{--fin segunda fila--}}
{{--tercera fila--}}
                        <div class="col-2">
                            <div class="form-floating mb-3">
                                <input type="text" value="" class="form-control" id="minExistence">
                                <label for="floatingMinExistence">Existencia Mínima</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-floating mb-3">
                                <input type="text" value="" class="form-control" id="maxExistence">
                                <label for="floatingMaxExistence">Existencia Máxima</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-floating mb-3">
                                <input type="text" value="" class="form-control" id="avgPrice">
                                <label for="floatingAvgPrice">Precio Promedio</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-floating mb-3">
                                <input type="text" value="" class="form-control" id="lastPrice">
                                <label for="floatingLastPrice">Ultimo Precio</label>
                            </div>
                        </div>
                            <div class="col-6 col-md-4">
                                <div class="form-floating mb-1">
                                    <input type="file" class="form-control" id="floatingFoto" />
                                    <label for="floatingFoto" style="text-transform: uppercase;"><strong>
                                            FOTO</strong></label>

                                </div>
                            </div>
                        </div>
                    </div>
{{--fin tercera fila--}}
{{--cuarta fila--}}
            <div class="container mb-3">
                <div class="row">
                    <div class="col-8">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Observaciones"
                                id="floatingObservaciones" style="height: 230px"></textarea>
                            <label for="floatingObservaciones">Observaciones</label>
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
            {{-- <div class="modal-body form-group">
                <div class="container">
                    <div class="container px-4">
                        <div class="row gx-3">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" class="form-control" id="CodeArticle">
                                    <label for="floatingCodeArticle">Código</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input type="text" value="" class="form-control" id="descriptionArticle">
                                        <label for="floatingDescriptionArticle">Descripción</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col ">
                                    <select class="form-select mb-3" id="floatingselectActive"
                                    aria-label="active_Article">
                                    <option value="0" >Activo</option>
                                    <option value="1">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="container px-4">
                        <div class="row gx-3">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingselectAccountGroup"
                                        aria-label="Grupo contable">
                                        <option value="0" >0</option>
                                        <option value="1">1</option>
                                    </select>
                                    <label for="floatingselectAccountGroup">Grupo Contable</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingselectArticleGroup"
                                        aria-label="Grupo artículo">
                                        <option value="0" >0</option>
                                        <option value="1">1</option>
                                    </select>
                                    <label for="floatingselectArticleGroup">Grupo Articulo</label>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="floatingselectArticleType"
                                        aria-label="Tipo de artículo">
                                        <option value="0" >0</option>
                                        <option value="1">1</option>
                                    </select>
                                    <label for="floatingselectArticleType">Tipo de Articulo</label>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>

                    <div class="container px-4">
                        <div class="row gx-3">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" class="form-control" id="floatingPrimerApellido"
                                        placeholder="Rodriguez" name="floatingPrimerApellido">
                                    <label for="floatingPrimerApellido">P. Apellido</label>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="floatingSegundoApellido" class="form-control"
                                        id="floatingSegundoApellido" placeholder="Suarez">
                                    <label for="floatingSegundoApellido">S. Apellido</label>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" class="form-control" id="floatingPrimerNombre"
                                        placeholder="Edward" name="floatingPrimerNombre">
                                    <label for="floatingPrimerNombre">P. Nombre</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="floatingSegundoNombre" class="form-control"
                                        id="floatingSegundoNombre" placeholder="Andres">
                                    <label for="floatingSegundoNombre">S. Nombre</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container px-4">
                        <div class="row row-cols-2 row-cols-lg-3 g-2 g-lg-3">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="floatingDireccion" class="form-control"
                                        id="floatingDireccion" placeholder="Av3#15">
                                    <label for="floatingDireccion">Dirección</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" value="" name="floatingEmail" class="form-control"
                                        id="floatingEmail" placeholder="example@gmail.com">
                                    <label for="floatingEmail">Correo Electronico</label>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="email" value="" name="floatingTelefonoFijo" class="form-control"
                                        id="floatingTelefonoFijo" placeholder="example@gmail.com">
                                    <label for="floatingTelefonoFijo">Telefono Fijo</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" value="" name="floatingMunicipio" class="form-control"
                                        id="floatingMunicipio" placeholder="Cúcuta">
                                    <label for="floatingMunicipio">Municipio</label>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="email" value="" class="form-control" name="floatingNumeroCelular"
                                        id="floatingNumeroCelular" placeholder="example@gmail.com">
                                    <label for="floatingNumeroCelular">N. Celular</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="floatingfechaNacimiento"
                                        name="floatingfechaNacimiento" placeholder="20/05/2000" value="" required>
                                    <label for="floatingfechaNacimiento"
                                        style="text-transform: uppercase;"><strong>Fecha Nacimiento</strong></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container px-4">
                        <div class="row g-1">
                            <div class="col-sm-6 col-md-8">
                                <div class="input-group">
                                    <div class="">
                                        <select id="selectTipoTercero" class="form-select  " multiple>
                                            <option selected>Seleccione Tipo Tercero</option>
                                            
                                            <option value="1">1</option>
                                            
                                        </select>
                                    </div>

                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Observaciones"
                                            id="floatingObservaciones" style="height: 290px"></textarea>
                                        <label for="floatingObservaciones">Observaciones</label>
                                    </div>

                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-floating mb-0">
                                    <input type="file" class="form-control" id="floatingFoto" />
                                    <label for="floatingFoto" style="text-transform: uppercase;"><strong>
                                            FOTO</strong></label>
                                    <img id="imagenPrevisualizacion"
                                        src="https://images.pexels.com/photos/733872/pexels-photo-733872.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500"
                                        class="img-thumbnail">
                                    <img>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary uppercase" data-bs-dismiss="modal">cancelar</button>
                <button id="btnArticle_type" type="button" class="btn btn-primary uppercase">guardar</button>
            </div>
        </form>
        </div>
    </div>
</div>