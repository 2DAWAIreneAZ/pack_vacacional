<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Paquetes Vacacionales</h2>
            @if(Auth::user()->isAdmin() || Auth::user()->isAdvanced())
                <a href="{{ route('vacaciones.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    + Agregar Nuevo Paquete
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    ❌ {{ session('error') }}
                </div>
            @endif

            <!-- Filtros -->
            <div class="mb-6 bg-white p-6 rounded-lg shadow">
                <form method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Búsqueda -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                            <input type="text" name="search" placeholder="Título, descripción o país..." 
                                   value="{{ request('search') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <!-- Tipo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Vacación</label>
                            <select name="tipo" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Todos los tipos</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}" {{ request('tipo') == $tipo->id ? 'selected' : '' }}>
                                        {{ $tipo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- País -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">País</label>
                            <input type="text" name="pais" placeholder="Ej: España, México..." 
                                   value="{{ request('pais') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Precio mínimo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Precio Mínimo ($)</label>
                            <input type="number" name="precio_min" step="0.01" placeholder="0.00" 
                                   value="{{ request('precio_min') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Precio máximo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Precio Máximo ($)</label>
                            <input type="number" name="precio_max" step="0.01" placeholder="10000.00" 
                                   value="{{ request('precio_max') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Ordenar por -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ordenar por</label>
                            <select name="orden" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Más recientes</option>
                                <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                                <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                                <option value="titulo_asc" {{ request('orden') == 'titulo_asc' ? 'selected' : '' }}>Título: A-Z</option>
                                <option value="titulo_desc" {{ request('orden') == 'titulo_desc' ? 'selected' : '' }}>Título: Z-A</option>
                            </select>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold">
                                Filtrar
                            </button>
                            <a href="{{ route('vacaciones.index') }}" class="flex-1 text-center bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded font-semibold">
                                Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Grid de Paquetes -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($vacaciones as $vacacion)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                        <!-- Imagen principal -->
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $vacacion->primera_foto }}" 
                                 alt="{{ $vacacion->titulo }}" 
                                 class="w-full h-full object-cover hover:scale-110 transition duration-300">
                            <div class="absolute top-3 right-3 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                ${{ number_format($vacacion->precio, 2) }}
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <!-- Tipo y País -->
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-blue-600 bg-blue-50 px-3 py-1 rounded-full font-semibold">
                                    {{ $vacacion->tipo->nombre }}
                                </span>
                                <span class="text-xs text-gray-500 font-medium">
                                    {{ $vacacion->pais }}
                                </span>
                            </div>

                            <!-- Título -->
                            <h3 class="font-bold text-lg mb-2 text-gray-800 line-clamp-2">
                                {{ $vacacion->titulo }}
                            </h3>

                            <!-- Descripción -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $vacacion->descripcion }}
                            </p>

                            <!-- Comentarios -->
                            @if($vacacion->comentarios->count() > 0)
                                <div class="flex items-center mb-4 text-sm text-gray-500">
                                    <span class="text-yellow-400">⭐</span>
                                    <span class="ml-1">{{ $vacacion->comentarios->count() }} comentarios</span>
                                </div>
                            @endif

                            <!-- Botones de acción -->
                            <div class="flex gap-2">
                                <a href="{{ route('vacaciones.show', $vacacion) }}" 
                                   class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded font-semibold transition">
                                    Ver Detalles
                                </a>

                                @can('update', $vacacion)
                                    <a href="{{ route('vacaciones.edit', $vacacion) }}"
                                       class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-gray-800 text-center py-2 rounded font-semibold transition">
                                        Editar
                                    </a>
                                @endcan

                                @can('delete', $vacacion)
                                    <form action="{{ route('vacaciones.destroy', $vacacion) }}" method="POST" class="flex-1"
                                          onsubmit="return confirm('¿Eliminar este paquete vacacional?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded font-semibold transition">
                                            Eliminar
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-lg shadow">
                        <div class="text-6xl mb-4"></div>
                        <p class="text-gray-500 text-lg">No se encontraron paquetes vacacionales.</p>
                        <p class="text-gray-400 text-sm mt-2">Intenta ajustar los filtros de búsqueda.</p>
                    </div>
                @endforelse
            </div>

            <!-- Paginación -->
            <div class="mt-8">
                {{ $vacaciones->links() }}
            </div>
        </div>
    </div>
</x-app-layout>