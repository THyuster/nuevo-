{{--@extends('layouts.configuracion_vistapadre')
@extends('dashboard')


@section('contenidoPrincipal')

<h2></h2>
<h2>Crear Nuevo Usuario</h2>

<form action="/articulos" method="POST">

    @csrf

    <div class="mb-3">
        <label for="" class="from-label">Codigo</label>
        <input id="codigo" name="codigo" type="text" class="form-control" tableindex="1">
    </div>

    <div class="mb-3">
        <label for="" class="from-label">Descripcion</label>
        <input id="descripcion" name="descripcion" type="text" class="form-control" tableindex="2">
    </div>

    <div class="mb-3">
        <label for="" class="from-label">Cantidad</label>
        <input id="cantidad" name="cantidad" type="number" class="form-control" tableindex="3">
    </div>

    <div class="mb-3">
        <label for="" class="from-label">Precio</label>
        <input id="precio" name="precio" type="number" step="any" value="0.00" class="form-control" tableindex="4">
    </div>

    <a href="/articulos" class="btn btn-secondary" tabindex="5">Cancelar</a>
    <button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>

    </from>

    @endsection --}} {{--usuarios no usa create debido a su creación de usuarios, solo se editan permisos de
    activación--}}