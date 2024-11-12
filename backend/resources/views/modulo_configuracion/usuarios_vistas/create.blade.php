@extends('layouts.srm_vistapadre')
@extends('dashboard')
@extends('layouts.navbar')

@section('contenidoPrincipal')

<h2></h2>
<h2>Crear Nueva Vista:</h2>

<div class="container">

    <form action="/usuarios_vistas" method="POST">

        @csrf

        <div class="col-md-4">
            <label for="modulo" class="form-label">Modulo: </label>
            <select id="modulo" name="modulo" class="form-select" aria-label="Default select example" tableindex="1"
                required>
                <option selected></option>
                @foreach ($modulosx as $modulo)
                <option value="{{ $modulo['id']}}">{{$modulo['codigo']}} - {{$modulo['descripcion']}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="" class="from-label">codigo:</label>
            <input id="codigo" name="codigo" type="text" class="form-control" tableindex="2" required>
        </div>

        <div class="mb-3">
            <label for="" class="from-label">menu:</label>
            <input id="menu" name="menu" type="text" class="form-control" tableindex="3" required>
        </div>

        <div class="mb-3">
            <label for="" class="from-label">submenu</label>
            <input id="submenu" name="submenu" type="text" class="form-control" tableindex="4" required>
        </div>

        <div class="mb-3">
            <label for="" class="from-label">vista</label>
            <input id="vista" name="vista" type="text" class="form-control" tableindex="5" required>
        </div>

        <div class="mb-3">
            <label for="" class="from-label">ruta</label>
            <input id="ruta" name="ruta" type="text" class="form-control" tableindex="6" required>
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