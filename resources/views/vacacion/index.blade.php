<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if(Auth::user()->isAdmin())
                    Gestión de Paquetes Vacacionales
                @else
                    Todos los Paquetes Vacacionales
                @endif
            </h2>
            @if(Auth::user()->isAdmin() || Auth::user()->isAdvanced())
                <a href="{{ route('vacaciones.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                    + Crear Paquete
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filtros de búsqueda -->
            <div class="mb-6 flex gap-4">
                <form method="GET" class="flex gap-4 w-full">
                    <input type="text" name="search" placeholder="Buscar destinos..." 
                           value="{{ request('search') }}"
                           class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    
                    <select name="tipo" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todos los Tipos</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}" {{ request('tipo') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                    
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-6 py-2 rounded transition">
                        Filtrar
                    </button>
                    <a href="{{ route('vacaciones.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-6 py-2 rounded transition">
                        Limpiar
                    </a>
                </form>
            </div>

            <!-- Grid de paquetes vacacionales -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($vacaciones as $vacacion)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                        @if($vacacion->fotos->first())
                            <img src="{{ $vacacion->fotos->first()->url_foto }}" 
                                 alt="{{ $vacacion->destino }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                <span class="text-white text-4xl"></span>
                            </div>
                        @endif
                        
                        <div class="p-4">
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $vacacion->tipo->nombre }}</span>
                            <h3 class="font-bold text-lg mb-2 mt-2">{{ Str::limit($vacacion->destino, 40) }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($vacacion->descripcion, 80) }}</p>
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-2xl font-bold text-blue-600">${{ number_format($vacacion->precio, 2) }}</span>
                                <span class="text-sm text-gray-500">{{ $vacacion->duracion }} días</span>
                            </div>

                            <div class="mb-3 text-sm text-gray-600">
                                <span class="font-semibold">Inicia:</span> {{ \Carbon\Carbon::parse($vacacion->fecha_inicio)->format('d/m/Y') }}
                            </div>

                            @php
                                $avgRating = $vacacion->comentarios->avg('valoracion');
                                $totalComentarios = $vacacion->comentarios->count();
                                $totalReservas = $vacacion->reservas->count();
                            @endphp
                            @if($avgRating)
                                <div class="flex items-center mb-3">
                                    <span class="text-yellow-400">★</span>
                                    <span class="ml-1 text-sm">{{ number_format($avgRating, 1) }}</span>
                                    <span class="text-xs text-gray-500 ml-1">({{ $totalComentarios }})</span>
                                </div>
                            @endif

                            @if(Auth::user()->isAdmin())
                                <div class="mb-3 text-xs text-gray-600">
                                    <span class="font-semibold">Reservas:</span> {{ $totalReservas }}
                                </div>
                            @endif

                            <div class="flex gap-2 flex-wrap">
                                <a href="{{ route('vacaciones.show', $vacacion) }}" 
                                   class="flex-1 min-w-[80px] bg-gray-200 hover:bg-gray-300 text-center py-2 rounded font-semibold transition">
                                    Detalles
                                </a>

                                @can('update', $vacacion)
                                    <a href="{{ route('vacaciones.edit', $vacacion) }}"
                                       class="flex-1 min-w-[80px] bg-yellow-400 hover:bg-yellow-500 text-center py-2 rounded font-semibold transition">
                                        Editar
                                    </a>
                                @endcan

                                @can('delete', $vacacion)
                                    <form action="{{ route('vacaciones.destroy', $vacacion) }}" method="POST" class="flex-1 min-w-[80px]"
                                          onsubmit="return confirm('¿Eliminar este paquete?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded font-semibold transition">
                                            Eliminar
                                        </button>
                                    </form>
                                @endcan

                                @if(!Auth::user()->isAdmin())
                                    <form action="{{ route('vacaciones.reservar', $vacacion) }}" method="POST" class="flex-1 min-w-[80px]">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full bg-blue-500 hover:bg-blue-700 text-white py-2 rounded font-semibold transition">
                                            Reservar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No se encontraron paquetes vacacionales.</p>
                        @if(Auth::user()->isAdmin() || Auth::user()->isAdvanced())
                            <a href="{{ route('vacaciones.create') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Crear el Primer Paquete
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Paginación -->
            <div class="mt-6">
                {{ $vacaciones->links() }}
            </div>
        </div>
    </div>
</x-app-layout>