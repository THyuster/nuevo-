@extends('layouts.srm_vistapadre')
@extends('dashboard')



@section('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection



@section('contenidoPrincipal')

<div class="container-fluid">
    <h2>GESTION DE TERCEROS</h2>

    <a href="srm_terceros/create" class="btn btn-primary">Crear Nuevo Tercero:</a>
    <h2></br></h2>



    <table id="terceros" class="table table-blue table-striped mt-2">

        <thead>
            <tr>
                <th scope="col">TIPO</TH>
                <th scope="col">IDENT.</TH>
                <th scope="col">NOMBRE</TH>
                <th scope="col">EMPRESA</TH>
                <th scope="col">TELEFONO</TH>
                <th scope="col">EMAIL</TH>
                <th scope="col">TIPO</TH>
                <th scope="col">ESTADO</TH>
                <th scope="col">ACCION</TH>
            </tr>
        </thead>

        <tbody>
            @foreach ($terceros as $tercero)
            <tr>
                <td>{{ $tercero->tipo_identificacion }}</td>
                <td>{{ $tercero->identificacion }}</td>
                <td>{{ $tercero->apellidos }} {{ $tercero->nombres }}</td>
                <td>{{ $tercero->razon_social }}</td>
                <td>{{ $tercero->telefono }}</td>
                <td>{{ $tercero->email }}</td>
                <td>{{ $tercero->tipo_tercero }}</td>
                <td>{{ $tercero->estado }}</td>

                <td>
                    <form action="{{ route ('srm_terceros.destroy',$tercero->id) }}"
                        class="d-inline formulario-eliminar" method="POST">
                        <a href="/srm_terceros/{{$tercero->id}}/edit" class="btn btn-info">Editar</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Borrar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>




@section('js')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#terceros').DataTable({
            "lengthMenu": [
                [5, 10, 50, -1],
                [5, 10, 50, "All"]
            ]
        });

    });
</script>




<!-- VALIDACION DE REGISTRO DUPLICADO -->
@if( session('error') == 'duplicado')
<script>
    Swal.fire('Error !!! , Codigo Ya Existe ....')
</script>
@endif



<!-- INICIO ELIMINACION CON CONFIRMACION -->
@if( session('eliminar') == 'ok')
<script>
    Swal.fire('Borrado!', 'Su Registro Ha Sido Eliminado.', 'success');
</script>
@endif






<script>
    $('.formulario-eliminar').submit(function(e) {

        e.preventDefault(e);

        Swal.fire({
            title: 'Por Favor Confirmar..?',
            text: "Esta Seguro de la Eliminacion!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si , Borrar.!'
        }).then((result) => {

            if (result.isConfirmed) {
                /* Swal.fire(
                'Borrado!',
                'Su Registro Ha Sido Eliminado.',
                'success'
                ) */
                this.submit();
            }
        })

    })
</script>
<!-- INICIO ELIMINACION CON CONFIRMACION  -->


@endsection


@endsection