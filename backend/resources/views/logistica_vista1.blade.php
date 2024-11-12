@extends('layouts.logistica_vistapadre')
@extends('dashboard')
@section('contenidoPrincipal')

{{-- Esta vista es la vista después del login--}}

<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

    <div class="figure rounded mx-auto d-block">
        <img src="imagenes/logo_mla1.png" alt="" width="600">

        <div class="ml-4 text-lg leading-7 font-semibold"><a href=" " class="text-gray-900 dark:text-white">ERP Minas la
                Aurora - 2023 / Sistema de Planeacion de Recursos Empresariales ©</a></div>

    </div>
    <div class="mt-9 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2">

            <div class="p-6">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Informacion
                        General</a></div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                        Modulo principal de Logística </br>
                        Bienvenido/a </br>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                        <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Beneficios</a></div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                        * Acceso en linea gracias a su desarollo en Nube. </br>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center mt-4 sm:items-center sm:justify-between">

        <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
            Sistema Version {{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}) Diego Medina fullStack ing en proceso / Ing. Marvin J.
            Martinez A. - Whatsapp 322 714 5421 <b style="opacity: 0.25"> y sus secuases </b>
        </div>
    </div>
</div>


@endsection