@extends('layouts.srm_vistapadre')
@extends('dashboard')


@section('contenidoPrincipal')

<h2></h2>
<h2>Crear Nueva Vista:</h2>

<div class="container">

    <form action="/usuarios_vistas/{{$vista->id}}" method="POST">

        @csrf
        @method('PUT')

        <div class="col-md-2">
            <label for="modulo" class="form-label">Estado</label>
            <select id="modulo" name="modulo" class="form-select" value="{{$vista->modulo_id}}" required>
                <option value="{{$vista->modulo_id}}">{{$vista->modulo_id}}</option>
                <option value="">----------</option>
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
            </select>
        </div>



        <div class="mb-3">
            <label for="" class="from-label">codigo:</label>
            <input id="codigo" name="codigo" type="text" class="form-control" value="{{$vista->codigo}}" tableindex="2" required>
        </div>


     <!--   <div class="mb-3">
            <label for="" class="from-label">menu:</label>
            <input id="menu" name="menu" type="text" class="form-control" value="{{$vista->menu}}" tableindex="3" required>
        </div> -->



        <div class="mb-3">
            <label for="" class="from-label">submenu</label>
            <input id="submenu" name="submenu" type="text" class="form-control" value="{{$vista->submenu}}" tableindex="4" required>
        </div>

        <div class="mb-3">
            <label for="" class="from-label">vista</label>
            <input id="vista" name="vista" type="text" class="form-control" value="{{$vista->vista}}" tableindex="5" required>
        </div>


        <div class="mb-3">
            <label for="" class="from-label">ruta</label>
            <input id="ruta" name="ruta" type="text" class="form-control" value="{{$vista->ruta}}" tableindex="6" required>
        </div>





        <a href="/usuarios_vistas" class="btn btn-secondary" tabindex="7">Cancelar</a>
        <button type="submit" class="btn btn-primary" tabindex="8">Guardar</button>

        </from>

</div>


@section('js')

<!-- INICIO VALIDACION DUPLICADO  -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@if( session('error') == 'duplicado')
<script>
    Swal.fire('Error !!! , Codigo Ya Existe ....')
</script>
@endif

<!-- FIN VALIDACION DUPLICADO -->

@endsection

@endsection