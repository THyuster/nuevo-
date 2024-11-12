{{--Modal de creación--}}

<!-- Botón para abrir el modal -->
<div class="modal fade" tabindex="-1" id="modalExample" aria-labelledby="thirdPartiesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered modal-xl">
    
    <!-- Modal -->
    {{-- <div class="modal-xl modal fade" tabindex="-1"" id="modalExample" aria-hidden="true"> --}}
      {{-- <div class="modal-dialog"> --}}
        <div class="modal-content">
        
          <!-- Cabecera del modal -->
          <div class="modal-header">
            <h4 class="modal-title">Mi Modal con Navegación de Pestañas</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
          </div>
          
          <!-- Cuerpo del modal -->
          <div class="modal-body">
          
            <!-- Navegación de pestañas -->
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#pestaña1">Información básica</a>
              </li>
  
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#pestaña2">Referencias personales</a>
              </li>
  
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#pestaña3">Galería</a>
              </li>
            </ul>
            
            <!-- Contenido de las pestañas -->
            <div class="tab-content">
              <div class="tab-pane fade show active" id="pestaña1">
                {{-- Contenido de la pestaña 1 --}}