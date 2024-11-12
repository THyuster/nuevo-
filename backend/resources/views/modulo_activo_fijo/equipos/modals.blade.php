{{--modal de eliminación departamento--}}
<div class="modal fade" tabindex="-1" id="FourthParty" aria-labelledby="FourthPartiesLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Formulario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="fecha_actualizacion">Fecha de Actualización</label>
                <input type="date" class="form-control" id="fecha_actualizacion" placeholder="DD-MM-YYYY">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="fecha_inactivo">Fecha de Inactivo</label>
                <input type="date" class="form-control" id="fecha_inactivo" placeholder="DD-MM-YYYY">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="tipo_identificacion">Tipo de Identificación</label>
                <select class="form-control" id="tipo_identificacion">
                  <option value="CC">CC</option>
                  <option value="NIT">NIT</option>
                  <option value="TI">TI</option>
                  <option value="CE">CE</option>
                  <option value="PP">PP</option>
                  <option value="OTRO">OTRO</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="identificacion">Identificación</label>
                <input type="text" class="form-control" id="identificacion" maxlength="20">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="digito_verificacion">Dígito de Verificación</label>
                <select class="form-control" id="digito_verificacion">
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="nombre_completo">Nombre Completo</label>
                <input type="text" class="form-control" id="nombre_completo" maxlength="120">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="apellido1">Primer Apellido</label>
                <input type="text" class="form-control" id="apellido1" maxlength="20">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="apellido2">Segundo Apellido</label>
                <input type="text" class="form-control" id="apellido2" maxlength="20">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="nombre1">Primer Nombre</label>
                <input type="text" class="form-control" id="nombre1" maxlength="20">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="nombre2">Segundo Nombre</label>
                <input type="text" class="form-control" id="nombre2" maxlength="20">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="naturaleza_juridica">Naturaleza Jurídica</label>
                <select class="form-control" id="naturaleza_juridica">
                  <option value="natural">Natural</option>
                  <option value="juridica">Jurídica</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" placeholder="DD-MM-YYYY">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="grupo_sanguineo">Grupo Sanguíneo</label>
                <select class="form-control" id="grupo_sanguineo">
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="AB">AB</option>
                  <option value="O">O</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="tipo_sangre">Tipo de Sangre</label>
                <select class="form-control" id="tipo_sangre">
                  <option value="positivo">Positivo</option>
                  <option value="negativo">Negativo</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" id="direccion" maxlength="300">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" maxlength="60">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="telefono_fijo">Teléfono Fijo</label>
                <input type="tel" class="form-control" id="telefono_fijo" maxlength="40">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="movil">Móvil</label>
                <input type="tel" class="form-control" id="movil" maxlength="20">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="municipio">Municipio</label>
                <input type="number" class="form-control" id="municipio">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="tercero">Tercero</label>
                <select class="form-control" id="tercero">
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="observacion">Observación</label>
                <textarea class="form-control" id="observacion" rows="3" maxlength="300"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="estado">Estado</label>
                <select class="form-control" id="estado">
                  <option value="0">Inactivo</option>
                  <option value="1">Activo</option>
                </select>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div id="deleteThird" class="modal fade" tabindex="-1" aria-labelledby="createMenuLabel" aria-hidden="true">
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


<div id="updateThird" class="modal fade" tabindex="-1" aria-labelledby="createMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Confirmar eliminación</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">Actualizar!!!</p>
            </div>
            <div class="modal-footer">
                <button id="btnUpdateThird" class="btn btn-primary" type="submit">Borrar</button>
                <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
</div>

{{-- <div class="dropdown rounded-0 me-2">
  <button class="dropdown-toggle form-control form-select" type="button"
      id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
      aria-expanded="false">
      Seleccione Tipo Tercero
  </button>
  <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton"> --}}