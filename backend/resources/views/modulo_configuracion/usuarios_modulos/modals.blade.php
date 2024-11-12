{{--Modal de advertencia--}}
<div id="deletePermission" class="modal fade" tabindex="-1" aria-labelledby="createMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar el permiso?</p>
            </div>
            <div class="modal-footer">
                <button id="deleteConfirmButton" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>
{{--Modal de edición--}}
<div class="modal fade" id="editPermisos" tabindex="-1" aria-labelledby="editPermisosLabel" aria-hidden="true">
    <form id="addPermisosForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editPermisosLabel">Editar asignación</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{-- <label for="Nombre" class="form-label"></label> --}}                        
                        <p id="nombreUsuario"></p>
                        <label for="modulo" class="form-label">Modulo:</label>
                        <select name="modulosSelect" class="form-select" id="modulosSelect">
                            <option id="previosModule">Selecciona:</option>
                            @foreach ($modulos as $modulo)
                            <option value="{{$modulo->descripcion}}">{{$modulo->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnUpdatePermission" >Actualizar asignación</button>
                </div>
            </div>
        </div>
    </form>
</div>
{{--Modal de creación--}}
<div class="modal fade" id="createPermisos" tabindex="-1" aria-labelledby="createPermisosLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPermisosLabel">Crear Asignación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formPermisosCrear">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="usuario" class="form-label">Usuario:</label>
                        <select id="idUsuarioAsignacion" name="usuario" class="form-select" required>
                            <option selected>Seleccione</option>
                            @foreach ($users as $usuario)
                            <option value="{{ $usuario->id}}">{{$usuario->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modulo" class="form-label">Módulo:</label>
                        <select id="idModuloAsignacion" name="modulo" class="form-select" required>
                            <option selected>Seleccione</option>
                            @foreach ($modulos as $modulo)
                            <option value="{{ $modulo->id}}">{{$modulo->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-danger" data-bs-dismiss="modal" tabindex="5">Cancelar</a>
                    <button type="submit" id="btnCreatePermission" class="btn btn-primary" href="#AsignarPermiso"
                        tabindex="4">Crear asignación</button>
                </div>
            </form>
        </div>
    </div>
</div>
