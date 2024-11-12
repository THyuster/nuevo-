<div class="modal fade " id="createClient" tabindex="-1" aria-labelledby="createClientLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <form id="formCreateClient">
                <div class="modal-header ">
                    <h4 class="modal-title ml-1">Nuevo grupo empresarial</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="codigo" placeholder="codigo" name="codigo">
                        <label for="codigo">Codigo</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="descripcion" placeholder="descripcion" name="descripcion">
                        <label for="descripcion">descripción</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="nit" placeholder="codigo_id" name="nit">
                        <label for="nit">nit</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="telefono" placeholder="telefono" name="telefono">
                        <label for="telefono">Telefono</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="direccion" placeholder="direccion" name="direccion">
                        <label for="direccion">Dirección</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="tercero" list="datalistTercero_id" placeholder="tercero" name="tercero" autocomplete="off">
                        <datalist id="datalistTercero_id">
                            {{-- @foreach ($thirds as $third)
                                <option value="{{ $third->id }} - {{ $third->nombre_completo }}">
                            @endforeach --}}
                        </datalist>
                        <label for="tercero">Tercero</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="email" placeholder="Email" name="email" autocomplete="off">
                        <label for="email">Email</label>
                    </div>
                    {{-- <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="conexion" placeholder="conexion"
                            name="conexion">
                        <label for="conexion">conexión</label>
                    </div> --}}
                    <div class="form-floating mb-1">
                        <input type="file" class="form-control" name="ruta_imagen" id="ruta_imagen">
                        <label for="ruta_imagen">Foto</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="btnCreateClient" class="btn btn-success">confirmar</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade " id="editClient" tabindex="-1" aria-labelledby="editClientLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-sm ">
        <div class="modal-content">
            <form id="formEditClient">
                <div class="modal-header ">
                    <h4 class="modal-title ml-1">Actualizar grupo empresarial</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="codigo" placeholder="codigo" name="codigo">
                        <label for="codigo">Codigo</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="descripcion" placeholder="descripcion" name="descripcion">
                        <label for="descripcion">descripción</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="nit" placeholder="codigo_id" name="nit">
                        <label for="nit">nit</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="telefono" placeholder="telefono" name="telefono">
                        <label for="telefono">Telefono</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="direccion" placeholder="direccion" name="direccion">
                        <label for="direccion">Dirección</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="tercero" list="datalistTercero_id" placeholder="tercero_id" name="tercero" autocomplete="off">
                        {{-- <datalist id="datalistTercero_id">
                            @foreach ($thirds as $third)
                                <option value="{{ $third->id }} - {{ $third->nombre_completo }}">
                        @endforeach
                        </datalist> --}}
                        <label for="tercero">Tercero</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="email" placeholder="Email" name="email" autocomplete="off">
                        <label for="email">Email</label>
                    </div>
                    {{-- <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="conexion" placeholder="conexion"
                            name="conexion">
                        <label for="conexion">conexión</label>
                    </div> --}}
                    <div class="form-floating mb-1">
                        <input type="file" class="form-control" name="ruta_imagen" id="ruta_imagen">
                        <label for="ruta_imagen">Foto</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="btnEditClient" class="btn btn-success">confirmar</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="deleteClient" class="modal fade" tabindex="-1" aria-labelledby="deleteClientLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el cliente/grupo empresarial?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteClient" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>