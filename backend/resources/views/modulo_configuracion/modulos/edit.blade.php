@extends('layouts.srm_vistapadre')
@extends('dashboard')


@section('contenidoPrincipal')

<h2></h2>
<h2>Modificar Informacion del Tercero :</h2>




<form class="row g-3" action="/srm_terceros/{{$tercero->id}}" method="POST">

    @csrf
    @method('PUT')


    <div class="col-md-2">
        <label for="tipo_identificacion" class="form-label">Tipo de Identificacion:</label>
        <select id="tipo_identificacion" name="tipo_identificacion" class="form-select" value="{{$tercero->tipo_identificacion}}" required>
            <option value="{{$tercero->tipo_identificacion}}">{{$tercero->tipo_identificacion}}</option>
            <option value="">----------</option>
            <option value="CEDULA">CEDULA</option>
            <option value="NIT">NIT</option>
        </select>
    </div>



    <div class="col-md-2">
        <label for="" class="form-label">Identificacion:</label>
        <input id="identificacion" name="identificacion" type="text" class="form-control" value="{{$tercero->identificacion}}" required>
    </div>


    <div class="col-md-4">
        <label for="" class="form-label">Apellidos:</label>
        <input id="apellidos" name="apellidos" type="text" class="form-control" value="{{$tercero->apellidos}}" required>
    </div>


    <div class="col-md-4">
        <label for="" class="form-label">Nombres:</label>
        <input id="nombres" name="nombres" type="text" class="form-control" value="{{$tercero->nombres}}" required>
    </div>


    <div class="col-md-2">
        <label for="tipo_tercero" class="form-label">Tipo de Tercero:</label>
        <select id="tipo_tercero" name="tipo_tercero" class="form-select" value="{{$tercero->tipo_tercero}}" required>
            <option value="{{$tercero->tipo_tercero}}">{{$tercero->tipo_tercero}}</option>
            <option value="">----------</option>
            <option value="PROVEEDOR">PROVEEDOR</option>
            <option value="CLIENTE">CLIENTE</option>.
            <option value="TECNICO">TECNICO</option>
            <option value="AUXILIAR">AUXILIAR</option>
            <option value="MIXTO">MIXTO</option>
        </select>
    </div>


    <div class="col-md-3">
        <label for="" class="form-label">Direccion:</label>
        <input id="direccion" name="direccion" type="text" class="form-control" value="{{$tercero->direccion}}">
    </div>

    <div class="col-md-3">
        <label for="" class="form-label">E-mail:</label>
        <input id="email" name="email" type="text" class="form-control" value="{{$tercero->email}}">
    </div>

    <div class="col-md-3">
        <label for="" class="form-label">Telefono:</label>
        <input id="telefono" name="telefono" type="text" class="form-control" value="{{$tercero->telefono}}">
    </div>


    <div class="col-md-12">
        <label for="" class="form-label">Observaciones:</label>
        <input id="observaciones" name="observaciones" type="text" class="form-control" value="{{$tercero->observaciones}}">
    </div>


    <div class="col-md-2">
        <label for="estado" class="form-label">Estado:</label>
        <select id="estado" name="estado" class="form-select" value="{{$tercero->estado}}" required>
            <option value="{{$tercero->estado}}">{{$tercero->estado}}</option>
            <option value="">----------</option>
            <option value="ACTIVO">ACTIVO</option>
            <option value="INACTIVO">INACTIVO</option>
        </select>
    </div>


    <div class="col-md-3">
        <label for="" class="form-label">Razon Social:</label>
        <input id="razon_social" name="razon_social" type="text" class="form-control" value="{{$tercero->razon_social}}">
    </div>




    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck">
            <label class="form-check-label" for="gridCheck">
                Tercero Sancionado Temporalmente.
            </label>
        </div>
    </div>



    <div class="col-12">
        <a href="/srm_terceros" class="btn btn-secondary" tabindex="5">Cancelar</a>
        <button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>
    </div>

</form>


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