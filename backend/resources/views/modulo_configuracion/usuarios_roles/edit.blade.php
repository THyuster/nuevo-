@extends('layouts.srm_vistapadre')
@extends('dashboard')


@section('contenidoPrincipal')

<h2></h2>
<h2>Modificar información del rol:</h2>


<div class="container">


    <form action="/usuarios_roles/{{$Rol->id}}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="" class="from-label">Codigo</label>
            <input id="codigo" name="codigo" type="text" class="form-control" value="{{$Rol->codigo}}" required>
        </div>

        <div class="mb-3">
            <label for="" class="from-label">Descripcion</label>
            <input id="descripcion" name="descripcion" type="text" class="form-control" value="{{$Rol->descripcion}}"
                required>
        </div>

        <div class="mb-3">
            <label for="" class="from-label">Vista</label>
            <input id="descripcion" name="descripcion" type="text" class="form-control" value="{{$Rol->vista}}"
                required>
        </div>

        <div class="mb-3">
            <label for="" class="from-label">Estado</label>
            <input id="descripcion" name="descripcion" type="text" class="form-control" value="{{$Rol->estado}}"
                required>
        </div>


        <a href="/usuarios_roles" class="btn btn-secondary" tabindex="5">Cancelar</a>
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