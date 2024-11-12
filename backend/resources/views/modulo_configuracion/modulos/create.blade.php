@extends('layouts.srm_vistapadre')
@extends('dashboard')





@section('contenidoPrincipal')

<h2>Crear Nuevo Tercero:</h2>
<h2></br></h2>

<div class="container">

    <form class="row g-3" action="/srm_terceros" method="POST">
        @csrf


        <div class="container">
            <div class="row">
                <!-- linea-1 -->

                <div class="col-md-2 order-first">
                    <!-- col-1 -->
                    <label for="tipo_identificacion" class="form-label">Tipo :</label>
                    <select id="tipo_identificacion" name="tipo_identificacion" class="form-select">
                        <option value="CEDULA">CEDULA</option>
                        <option value="NIT">NIT</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <!-- col-2 -->
                    <label for="" class="form-label">Identificacion:</label>
                    <input id="identificacion" name="identificacion" type="text" class="form-control" value="" tableindex="1" required>
                </div>

                <div class="col-md-3 order-last">
                    <!-- col-3 -->
                    <div class="col-md-12">
                        <label for="" class="form-label">Apellidos:</label>
                        <input id="apellidos" name="apellidos" type="text" class="form-control" value="" tableindex="2" required>
                    </div>
                </div>

                <div class="col-md-3 order-last">
                    <!-- col-4 -->
                    <div class="col-md-12">
                        <label for="" class="form-label">Nombres:</label>
                        <input id="nombres" name="nombres" type="text" class="form-control" value="" tableindex="2" required>
                    </div>
                </div>

                <div class="col-md-2 order-last">
                    <!-- col-5 -->
                    <div class="col-md-12">
                        <label for="tipo_tercero" class="form-label">Tipo de Tercero:</label>
                        <select id="tipo_tercero" name="tipo_tercero" class="form-select">
                            <option value="PROVEEDOR">PROVEEDOR</option>
                            <option value="CLIENTE">CLIENTE</option>.
                            <option value="TECNICO">TECNICO</option>
                            <option value="AUXILIAR">AUXILIAR</option>
                            <option value="MIXTO">MIXTO</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="row">
                <!-- linea-2 -->
                </br>
            </div>

            <div class="row">
                <!-- linea-3 -->

                <div class="col order-first">
                    <!-- col-1 -->

                    <div class="col-md-11">
                        <label for="" class="form-label">Direccion:</label>
                        <input id="direccion" name="direccion" type="text" class="form-control" value="" tableindex="4" Enabled>
                    </div>


                    <div class="col-md-11">
                        <label for="" class="form-label">E-mail :</label>
                        <input id="email" name="email" type="text" class="form-control" value="" tableindex="5" Enabled>
                    </div>


                    <div class="col-md-11">
                        <label for="" class="form-label">Telefono :</label>
                        <input id="telefono" name="telefono" type="text" class="form-control" value="" tableindex="6" Enabled>
                    </div>




                </div>


                <div class="col-md-4 order-first">
                    <!-- col-2 -->
                    <div class="col-md-12">
                        <label for="" class="form-label">Razon Social :</label>
                        <input id="razon_social" name="razon_social" type="text" class="form-control" value="" tableindex="6" Enabled>
                    </div>

                    <div class="col-md-12">
                        <label for="estado" class="form-label">Estado</label>
                        <select id="estado" name="estado" class="form-select">
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="INACTIVO">INACTIVO</option>
                        </select>
                    </div>

                </div>

                <div class="col-md-3 order-first">
                    <!-- col-3 FOTO  -->
                    <div class="col-md-8">
                        <label for="" class="form-label">Foto Tercero:</label>

                    </div>

                </div>



            </div>


        </div>


        <div class="col-12">
            </br>
            <label for="" class="from-label">Observaciones:</label>
            <input id="observaciones" name="observaciones" type="text" step="any" value="" class="form-control" tableindex="8">
        </div>




        <div class="container">

            <div class="row">

                <div class="col-md-6">
                    <!-- Contenido de la columna izquierda -->



                    <div class="col-md-3">



                    </div>



                    <div class="col-md-3">

                    </div>











                </div>






                <div class="col-md-6">
                    <!-- Contenido de la columna derecha -->















                </div>
            </div>
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
        Swal.fire('Error !!! , Identificacion Ya Existe ....')
    </script>
    @endif

    <!-- FIN VALIDACION DUPLICADO -->

    @endsection


</div>


@endsection