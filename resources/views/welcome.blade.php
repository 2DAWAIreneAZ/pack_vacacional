<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paquetes Vacacionales - Tu Próxima Aventura</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="min-h-screen flex flex-col">
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-blue-600">Paquetes Vacacionales</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-blue-600 font-semibold transition">Panel de Control</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-semibold transition">Iniciar Sesión</a>
                            <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                Registrarse
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-1 flex items-center justify-center px-4">
            <div class="text-center max-w-4xl">
                <div class="mb-8">
                    <span class="text-8xl"></span>
                </div>
                <h2 class="text-6xl font-bold text-gray-800 mb-4 leading-tight">
                    Tu Próxima Aventura<br/>
                    <span class="text-blue-600">Empieza Aquí</span>
                </h2>
                <p class="text-2xl text-gray-600 mb-12 max-w-2xl mx-auto">
                    Descubre destinos increíbles alrededor del mundo. Playa, montaña, cruceros y mucho más.
                </p>
                
                <div class="grid md:grid-cols-4 gap-4 mb-12 max-w-3xl mx-auto">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="text-3xl mb-2"></div>
                        <p class="font-semibold text-gray-800">Playa</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="text-3xl mb-2"></div>
                        <p class="font-semibold text-gray-800">Montaña</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="text-3xl mb-2"></div>
                        <p class="font-semibold text-gray-800">Cruceros</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <div class="text-3xl mb-2"></div>
                        <p class="font-semibold text-gray-800">Cultural</p>
                    </div>
                </div>
                
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-block bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-4 px-10 rounded-lg text-xl shadow-lg transition">
                        Explorar Destinos
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-block bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-4 px-10 rounded-lg text-xl shadow-lg transition">
                        Comenzar Ahora
                    </a>
                @endauth
            </div>
        </main>

        <footer class="bg-white shadow-lg mt-12">
            <div class="max-w-7xl mx-auto px-4 py-6 text-center text-gray-600">
                <p>&copy; 2026 Paquetes Vacacionales. Tu próxima aventura te espera.</p>
            </div>
        </footer>
    </div>
</body>
</html>