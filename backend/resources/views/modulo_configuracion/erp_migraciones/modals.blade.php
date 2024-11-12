{{-- Modal de eliminación id:deleteMigration --}}
<div id="deleteMigration" class="modal fade" tabindex="-1" aria-labelledby="deleteMigracionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">¿Está seguro que desea eliminar la Migración?</p>
            </div>
            <div class="modal-footer">
                <button id="btnDeleteMigration" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal de edición --}}
<div class="modal fade" id="editarMigracion" tabindex="-1" aria-labelledby="editarMigracionLabel" aria-hidden="true">
    <form id="formPermisosEditar">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title uppercase" id="editarMigracionLabel">Editar Migracion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body form-group">
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="floatingTablaUpdate" placeholder="Tabla">
                        <label for="floatingTablaUpdate">Tabla</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="floatingCampoUpdate" placeholder="Campo">
                        <label for="floatingCampoUpdate">Campo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="floatingAtributoUpdate" placeholder="Atributo">
                        <label for="floatingAtributoUpdate">Atributo</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="rounded-0 form-control" value="" id="floatingAccionUpdate" placeholder="Ejecucion">
                        <label for="floatingAccionUpdate">Ejecucion</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea type="text" class="rounded-0 form-control" value="" id="floatingScriptUpdate" placeholder="Script"></textarea>
                        <label for="floatingScriptUpdate">Script:</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="btnUpdateMigracion" class="btn btn-success" href="#editarmigracion" tabindex="4"><i class="fa-solid fa-plus"></i></a>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Modal de creación --}}
<div class="modal fade" id="createMigration" tabindex="-1" aria-labelledby="createMigracionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title uppercase" id="createMigracionLabel">Crear Nueva Novedad de Migracion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formMigracionCrear" class="shadow">
                <div class="container">
                    <div class="modal-body form-group">
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" value="Tabla_X" id="floatingTabla" placeholder="Tabla">
                            <label for="floatingTabla">Tabla :</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" value="Campo_X" id="floatingCampo" placeholder="Campo">
                            <label for="floatingCampo">Campo:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" value="VARCHAR" id="floatingAtributo" placeholder="Atributo">
                            <label for="floatingAtributo">Atributo:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="rounded-0 form-control" value="APLICAR" id="floatingAccion" placeholder="Ejecucion">
                            <label for="floatingAccion">Ejecucion:</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea type="text" class="rounded-0 form-control" value="" id="floatingScript" placeholder="Script"></textarea>
                            <label for="floatingScript">Script:</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a id="btnCreateMigration" class="btn btn-success" href="#crearmigracion" tabindex="4">Confirmar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
