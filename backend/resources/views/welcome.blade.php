<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MLASuite ERP</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

</head>

<body class="antialiased">

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
            <a href="{{ url('/dashboard') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Inicio</a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Cerrar
                    sesión</button>
            </form>

            @else
            <a href="{{ route('login') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Iniciar
                sesión</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Registrarse</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="figure-img">
                <img src="imagenes/logo_mla1.png" class="img-fluid" alt="" width="500">
                <!-- <p>Sistema de Registro, Control y Mantenimiento de Maquinaria</p>
                    <p style = "font-family:semibold;">Sistema de Registro, Control y Mantenimiento de Maquinaria</p> -->
                <p></p>
                <div class="ml-4 text-lg leading-7 font-semibold"><a href=" " class="text-gray-900 dark:text-white">ERP
                        - Minas la Aurora 2023 / Sistema de Planeacion de Recursos Empresariales ©</a></div>
                <p></p>
                <p></p>
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
                                SRM es un Sistema en Linea construido para la gestion , control </br>
                                y mantenimiento de maquinaria, propocionando centralizacion de informacion. </br>
                                Gracias a su desarollo en linea permite la gestion de los procesos </br>
                                desde cualquier sitio, brindando a la parte administrativa y operativa mejorar el
                                trabajo colaborativo. </br>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">
                                Beneficios</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                - Acceso en linea gracias a su desarollo en Nube. </br>
                                - Conexion a Diversos Motores de Bases de Datos. </br>
                                - Capacidad de Expansion y Escalamiento . </br>
                                - Centralizacion de Informacion , Procesos y Autorizaciones. </br>
                                - Capacidad de Integracion a Diversion Sistemas. </br>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Reportes</a>
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                - Control de Inventarios. </br>
                                - Seguimiento de Consumos. </br>
                                - Datos Operacionales. </br>
                                - Exportacion de Matriz de Informacion. </br>
                                - Seguimientos a Mantenimientos. </br>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64" />
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Conectividad
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                - Conexion en Linea a TNS Software. </br>
                                - Acceso desde Cualquier Navegador. </br>
                                - Motor de Base de Datos MySql. </br>
                                - Integracion por API a Terceros. </br>
                                - Sistema de Backups Interno. </br>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



            <div class="flex justify-center mt-4 sm:items-center sm:justify-between">


                <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                    Sistema Version {{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}) Diego Medina fullStack ing en proceso / Ing.
                    Marvin J. Martinez A. - Whatsapp 322 714 5421 <b style="opacity: 0.25"> y sus secuases </b>
                </div>

            </div>


        </div>
    </div>
</body>

</html>