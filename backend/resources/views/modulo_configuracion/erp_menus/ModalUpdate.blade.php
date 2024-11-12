
<div class="modal fade" id="updateMenu" tabindex="-1" aria-labelledby="updateMenuLabel" aria-hidden="true">
  <form  id="addUpdateForm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateMenuLabel">Actualizar menu</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body update_modal" data-id="" >
        <div class="form-group">
        <label for="up_name">name</label>
        <input type="text" class="form-control" name="up_name" id="up_name" placeholder="Name">
        <label for="up_vista">vista</label>
        <input type="text" class="form-control" name="up_vista" id="up_vista" placeholder="Vista">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
        <button type="submit" class="btn btn-primary update_menu" id="addVista" >guardar cambios</button>
      </div>
    </div>
  </div>
  </form>
</div>