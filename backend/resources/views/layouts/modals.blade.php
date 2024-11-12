{{--Modal con barra de desplazamiento con esquema de dos columnas--}}
<div class="modal fade" tabindex="-1" id="fullScreen2" aria-labelledby="thirdPartiesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formulario de terceros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-group">
                <div class="container">
                    <div class="row">
                        <!-- Columna izquierda -->
                        <div class="col-md-6">
                            <label for="tipo_identificacion" class="form-label">Tipo :</label>
                            <select id="tipo_identificacion" name="tipo_identificacion" class="form-select">
                                <option value="CEDULA">CEDULA</option>
                                <option value="NIT">NIT</option>
                            </select>

                            <label for="" class="form-label">Identificacion:</label>
                            <input id="identificacion" name="identificacion" type="text" class="form-control" value="" tabindex="1" required>

                            <label for="" class="form-label">Apellidos:</label>
                            <input id="apellidos" name="apellidos" type="text" class="form-control" value="" tabindex="2" required>

                            <label for="" class="form-label">Nombres:</label>
                            <input id="nombres" name="nombres" type="text" class="form-control" value="" tabindex="2" required>

                            <label for="" class="form-label">Tipo de tercero:</label>
                            
                            <input id="thirdPartyType" name="apellidos" type="text" class="form-control" value="" tabindex="2" required>

                        </div>

                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <label for="" class="form-label">Direccion:</label>
                            <input id="direccion" name="direccion" type="text" class="form-control" value="" tabindex="4" enabled>

                            <label for="" class="form-label">E-mail :</label>
                            <input id="email" name="email" type="text" class="form-control" value="" tabindex="5" enabled>

                            <label for="" class="form-label">Telefono :</label>
                            <input id="telefono" name="telefono" type="text" class="form-control" value="" tabindex="6" enabled>

                            <label for="" class="form-label">Razon Social :</label>
                            <input id="razon_social" name="razon_social" type="text" class="form-control" value="" tabindex="6" enabled>

                            <label for="estado" class="form-label">Estado</label>
                            <select id="estado" name="estado" class="form-select">
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="INACTIVO">INACTIVO</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- linea-2 -->
                        </br>
                    </div>
                    <div class="row">
                        <!-- linea-3 -->
                        <div class="col">
                            <!-- col-1 -->
                            <div class="col-md-11">
                                <label for="" class="form-label">Foto Tercero:</label>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancelar</button>
                <button type="button" class="btn btn-primary">guardar cambios</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" id="fullScreen2" aria-labelledby="thirdPartiesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formulario de terceros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-group">
                <div class="container">
                    <div class="row">
                        <!-- Columna izquierda -->
                        <div class="col-md-6">
                            <label for="tipo_identificacion" class="form-label">Tipo :</label>
                            <select id="tipo_identificacion" name="tipo_identificacion" class="form-select">
                                <option value="CEDULA">CEDULA</option>
                                <option value="NIT">NIT</option>
                            </select>

                            <label for="" class="form-label">Identificacion:</label>
                            <input id="identificacion" name="identificacion" type="text" class="form-control" value="" tabindex="1" required>

                            <label for="" class="form-label">Apellidos:</label>
                            <input id="apellidos" name="apellidos" type="text" class="form-control" value="" tabindex="2" required>

                            <label for="" class="form-label">Nombres:</label>
                            <input id="nombres" name="nombres" type="text" class="form-control" value="" tabindex="2" required>

                            <label for="" class="form-label">Tipo de tercero:</label>
                            
                            <input id="thirdPartyType" name="apellidos" type="text" class="form-control" value="" tabindex="2" required>

                        </div>

                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <label for="" class="form-label">Direccion:</label>
                            <input id="direccion" name="direccion" type="text" class="form-control" value="" tabindex="4" enabled>

                            <label for="" class="form-label">E-mail :</label>
                            <input id="email" name="email" type="text" class="form-control" value="" tabindex="5" enabled>

                            <label for="" class="form-label">Telefono :</label>
                            <input id="telefono" name="telefono" type="text" class="form-control" value="" tabindex="6" enabled>

                            <label for="" class="form-label">Razon Social :</label>
                            <input id="razon_social" name="razon_social" type="text" class="form-control" value="" tabindex="6" enabled>

                            <label for="estado" class="form-label">Estado</label>
                            <select id="estado" name="estado" class="form-select">
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="INACTIVO">INACTIVO</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <!-- linea-2 -->
                        </br>
                    </div>
                    <div class="row">
                        <!-- linea-3 -->
                        <div class="col">
                            <!-- col-1 -->
                            <div class="col-md-11">
                                <label for="" class="form-label">Foto Tercero:</label>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancelar</button>
                <button type="button" class="btn btn-primary">guardar cambios</button>
            </div>
        </div>
    </div>
</div>