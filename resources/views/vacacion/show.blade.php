<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalles del Paquete
            </h2>
            <div class="flex gap-2">
                @can('update', $vacacion)
                    <a href="{{ route('vacaciones.edit', $vacacion) }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-2 px-4 rounded transition">
                        Editar
                    </a>
                @endcan
                <a href="{{ route('vacaciones.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Galería de fotos -->
                        <div>
                            @if($vacacion->fotos->first())
                                <img src="{{ $vacacion->fotos->first()->url_foto }}" 
                                     alt="{{ $vacacion->destino }}" 
                                     class="w-full rounded-lg shadow-lg mb-4">
                                
                                @if($vacacion->fotos->count() > 1)
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach($vacacion->fotos->skip(1)->take(4) as $foto)
                                            <img src="{{ $foto->url_foto }}" 
                                                 alt="{{ $vacacion->destino }}" 
                                                 class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75">
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                <div class="w-full h-96 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex items-center justify-center">
                                    <span class="text-white text-6xl"></span>
                                </div>
                            @endif
                        </div>

                        <!-- Información del paquete -->
                        <div>
                            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded">{{ $vacacion->tipo->nombre }}</span>
                            <h1 class="text-3xl font-bold mb-4 mt-2">{{ $vacacion->destino }}</h1>
                            <p class="text-gray-700 mb-4">{{ $vacacion->descripcion }}</p>
                            
                            <div class="mb-4 space-y-2">
                                <div class="flex items-center">
                                    <span class="text-4xl font-bold text-blue-600">${{ number_format($vacacion->precio, 2) }}</span>
                                    <span class="ml-4 text-gray-600">por persona</span>
                                </div>
                                <div class="text-gray-600">
                                    <span class="font-semibold">Duración:</span> {{ $vacacion->duracion }} días
                                </div>
                                <div class="text-gray-600">
                                    <span class="font-semibold">Fecha de inicio:</span> {{ \Carbon\Carbon::parse($vacacion->fecha_inicio)->format('d/m/Y') }}
                                </div>
                            </div>

                            @php
                                $avgRating = $vacacion->comentarios->avg('valoracion');
                                $totalComentarios = $vacacion->comentarios->count();
                                $totalReservas = $vacacion->reservas->count();
                            @endphp
                            @if($avgRating)
                                <div class="flex items-center mb-4">
                                    <span class="text-yellow-400 text-2xl">★</span>
                                    <span class="ml-2 text-xl">{{ number_format($avgRating, 1) }}</span>
                                    <span class="ml-2 text-gray-500">({{ $totalComentarios }} valoraciones)</span>
                                </div>
                            @endif

                            @if(Auth::user()->isAdmin())
                                <div class="mb-6 p-4 bg-purple-50 border border-purple-200 rounded">
                                    <h3 class="font-bold text-purple-800 mb-2">Estadísticas (Admin)</h3>
                                    <p class="text-sm text-purple-700">Total de reservas: {{ $totalReservas }}</p>
                                    <p class="text-sm text-purple-700">Ingresos estimados: ${{ number_format($totalReservas * $vacacion->precio, 2) }}</p>
                                </div>
                            @endif

                            @if(!Auth::user()->isAdmin())
                                <form action="{{ route('vacaciones.reservar', $vacacion) }}" method="POST" class="mb-4">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded text-lg transition">
                                        Reservar Ahora
                                    </button>
                                </form>
                            @endif

                            <div class="flex gap-2">
                                @can('update', $vacacion)
                                    <a href="{{ route('vacaciones.edit', $vacacion) }}" 
                                       class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-center text-gray-800 font-semibold py-2 px-4 rounded transition">
                                        Editar Paquete
                                    </a>
                                @endcan
                                
                                @can('delete', $vacacion)
                                    <form action="{{ route('vacaciones.destroy', $vacacion) }}" method="POST" class="flex-1"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este paquete?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition">
                                            Eliminar Paquete
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <!-- Sección de comentarios -->
                    <div class="mt-8 border-t pt-8">
                        <h2 class="text-2xl font-bold mb-4">Agregar Tu Valoración</h2>
                        <form action="{{ route('vacaciones.comentario', $vacacion) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Calificación</label>
                                <select name="valoracion" class="shadow border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="5">★★★★★ (5) - Excelente</option>
                                    <option value="4">★★★★☆ (4) - Muy Bueno</option>
                                    <option value="3">★★★☆☆ (3) - Bueno</option>
                                    <option value="2">★★☆☆☆ (2) - Regular</option>
                                    <option value="1">★☆☆☆☆ (1) - Malo</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Comentario</label>
                                <textarea name="comentario" rows="3" 
                                          class="shadow border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Comparte tu experiencia con este destino..."></textarea>
                            </div>
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                                Publicar Valoración
                            </button>
                        </form>
                    </div>

                    <!-- Lista de comentarios -->
                    @if($vacacion->comentarios->count() > 0)
                        <div class="mt-8 border-t pt-8">
                            <h2 class="text-2xl font-bold mb-4">Valoraciones de Viajeros ({{ $totalComentarios }})</h2>
                            @foreach($vacacion->comentarios->sortByDesc('created_at') as $comentario)
                                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <span class="font-bold">{{ $comentario->user->name }}</span>
                                            <span class="ml-4 text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    {{ $i <= $comentario->valoracion ? '★' : '☆' }}
                                                @endfor
                                            </span>
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($comentario->comentario)
                                        <p class="text-gray-700">{{ $comentario->comentario }}</p>
                                    @endif
                                    
                                    @if(Auth::id() === $comentario->id_user || Auth::user()->isAdmin())
                                        <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 text-sm"
                                                    onclick="return confirm('¿Eliminar este comentario?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>