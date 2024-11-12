@extends('layouts.srm_vistapadre')
@extends('dashboard')


@section('contenidoPrincipal')

<h2></h2>
<h2>Crear nuevo rol</h2>

<div class="container">

    <form action="/srm_grupos" method="POST">

        @csrf

        <div class="mb-3">
            <label for="" class="from-label">Codigo</label>
            <input id="codigo" name="codigo" type="text" class="form-control" tableindex="1" required>
        </div>

        <!-- <div class="mb-3">
            <label for="" class="from-label">Descripcion</label>
            <input id="descripcion" name="descripcion" type="text" class="form-control" tableindex="2" required>
        </div> -->

        <select class="form-select form-select-sm" aria-label=".form-select-sm example">
            <option selected>Asignar rol</option>
            <option value="1">Contabilidad</option>
            <option value="2">Recursos humanos</option>
            <option value="3">Mineria</option>
        </select>


        <a href="/srm_grupos" class="btn btn-secondary" tabindex="5">Cancelar</a>
        <button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>

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