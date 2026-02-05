<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">¡Bienvenido, {{ Auth::user()->name }}! </h3>
                    
                    @if(Auth::user()->isAdmin())
                        <div class="mb-6 p-4 bg-purple-50 border border-purple-200 rounded-lg">
                            <p class="text-purple-800 font-semibold">Modo Administrador</p>
                            <p class="text-purple-600 text-sm">Tienes acceso completo para gestionar todos los paquetes vacacionales y usuarios del sistema.</p>
                        </div>
                        
                        <div class="grid md:grid-cols-3 gap-6">
                            <a href="{{ route('vacaciones.index') }}" 
                               class="block p-6 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg hover:shadow-lg transition">
                                <h4 class="text-xl font-bold mb-2">Gestionar Paquetes</h4>
                                <p class="text-gray-700">Ver, crear, editar y eliminar paquetes vacacionales</p>
                            </a>
                            
                            <a href="{{ route('vacaciones.create') }}" 
                               class="block p-6 bg-gradient-to-br from-green-100 to-green-200 rounded-lg hover:shadow-lg transition">
                                <h4 class="text-xl font-bold mb-2">+ Crear Paquete</h4>
                                <p class="text-gray-700">Agregar nuevos destinos vacacionales</p>
                            </a>
                            
                            <a href="{{ route('profile.show') }}" 
                               class="block p-6 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg hover:shadow-lg transition">
                                <h4 class="text-xl font-bold mb-2">Mi Perfil</h4>
                                <p class="text-gray-700">Ver mi información y estadísticas</p>
                            </a>
                        </div>
                    @elseif(Auth::user()->isAdvanced())
                        <div class="mb-6 p-4 bg-indigo-50 border border-indigo-200 rounded-lg">
                            <p class="text-indigo-800 font-semibold">Cuenta Avanzada</p>
                            <p class="text-indigo-600 text-sm">Puedes crear nuevos paquetes vacacionales y reservar destinos increíbles.</p>
                        </div>
                        
                        <div class="grid md:grid-cols-3 gap-6">
                            <a href="{{ route('vacaciones.index') }}" 
                               class="block p-6 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg hover:shadow-lg transition">
                                <h4 class="text-xl font-bold mb-2">Explorar Paquetes</h4>
                                <p class="text-gray-700">Descubre destinos increíbles</p>
                            </a>
                            
                            <a href="{{ route('vacaciones.create') }}" 
                               class="block p-6 bg-gradient-to-br from-green-100 to-green-200 rounded-lg hover:shadow-lg transition">
                                <h4 class="text-xl font-bold mb-2">+ Crear Paquete</h4>
                                <p class="text-gray-700">Agregar nuevos destinos</p>
                            </a>
                            
                            <a href="{{ route('profile.show') }}" 
                               class="block p-6 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg hover:shadow-lg transition">
                                <h4 class="text-xl font-bold mb-2">Mis Reservas</h4>
                                <p class="text-gray-700">Ver mis vacaciones reservadas</p>
                            </a>
                        </div>
                    @else
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-blue-800 font-semibold">Cuenta de Viajero</p>
                            <p class="text-blue-600 text-sm">¡Explora y reserva increíbles paquetes vacacionales!</p>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <a href="{{ route('vacaciones.index') }}" 
                               class="block p-6 bg-gradient-to-br from-green-100 to-green-200 rounded-lg hover:shadow-lg transition">
                                <h4 class="text-xl font-bold mb-2">Explorar Destinos</h4>
                                <p class="text-gray-700">Descubre paquetes vacacionales increíbles</p>
                            </a>
                            
                            <a href="{{ route('profile.show') }}" 
                               class="block p-6 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg hover:shadow-lg transition">
                                <h4 class="text-xl font-bold mb-2">Mis Reservas</h4>
                                <p class="text-gray-700">Ver mis vacaciones y comentarios</p>
                            </a>
                        </div>
                    @endif

                    <div class="mt-8 p-4 bg-gray-100 rounded-lg">
                        <p class="text-sm text-gray-600">
                            <strong>Tipo de Cuenta:</strong> 
                            <span class="ml-2 px-3 py-1 rounded-full text-xs font-semibold
                                @if(Auth::user()->isAdmin())
                                    bg-purple-200 text-purple-800
                                @elseif(Auth::user()->isAdvanced())
                                    bg-indigo-200 text-indigo-800
                                @else
                                    bg-blue-200 text-blue-800
                                @endif">
                                @if(Auth::user()->isAdmin())
                                    Administrador
                                @elseif(Auth::user()->isAdvanced())
                                    Usuario Avanzado
                                @else
                                    Viajero
                                @endif
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>