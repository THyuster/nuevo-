@extends('layouts.configuracion_vistapadre')
@extends('dashboard')
@section('contenidoPrincipal')




<div class="justify-content-md-center">

    <div class="container-fluid">
        <h2>Configuración del Usuario:</h2>
        <form action="/usuarios/{{$usuario->id}}" method="POST">
            @csrf
            @method('PUT')
            <fieldset disabled>
                <label>
                    <label for="" class="from-label">Nombre :</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{$usuario->name}}"
                        style="width: 400px; margin-bottom: 10px;">
                </label>
            </fieldset>


            <fieldset disabled>
                <label>
                    <label for="" class="from-label">correo electrónico:</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{$usuario->email}}"
                        style="width: 400px; margin-bottom: 10px;">
                </label>
            </fieldset>

            <div class="mb-3">
                <label class="from-label">Administrador</label>
                <select id="administrador" name="administrador" class="form-select" style="width: 220px">
                    <option value="NO">NO</option>
                    <option value="SI">SI</option>
                </select>
            </div>


            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select id="estado" name="estado" class="form-select" value="{{$usuario->estado}}" style="width: 220px"
                    required>
                    <option value="{{$usuario->estado}}">{{$usuario->estado}}</option>
                    <option value="">----------</option>
                    <option value="ACTIVO">ACTIVO</option>
                    <option value="INACTIVO">INACTIVO</option>
                </select>
            </div>
            <br>

            <a href="/usuarios" class="btn btn-danger" tabindex="5">Cancelar</a>
            <button type="submit" class="btn btn-primary" tabindex="4">Guardar</button>
    </div>
    </form>


</div>

@endsection