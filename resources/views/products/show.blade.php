<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalles del Paquete</h2>
            <a href="{{ route('vacaciones.index') }}" class="text-blue-500 hover:text-blue-700 font-semibold">
                ← Volver a Paquetes
            </a>
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Galería de Fotos -->
                        <div>
                            @if($vacacion->fotos->count() > 0)
                                <div class="space-y-4">
                                    <!-- Foto principal -->
                                    <img id="mainImage" 
                                         src="{{ $vacacion->fotos->first()->ruta }}" 
                                         alt="{{ $vacacion->titulo }}" 
                                         class="w-full h-96 object-cover rounded-lg shadow-lg">
                                    
                                    <!-- Miniaturas -->
                                    @if($vacacion->fotos->count() > 1)
                                        <div class="grid grid-cols-4 gap-2">
                                            @foreach($vacacion->fotos as $foto)
                                                <img src="{{ $foto->ruta }}" 
                                                     alt="Foto {{ $loop->iteration }}"
                                                     onclick="document.getElementById('mainImage').src='{{ $foto->ruta }}'"
                                                     class="w-full h-24 object-cover rounded cursor-pointer hover:opacity-75 transition">
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @else
                                <img src="https://placehold.co/600x400?text=Sin+Fotos" 
                                     alt="Sin fotos" 
                                     class="w-full rounded-lg shadow-lg">
                            @endif
                        </div>

                        <!-- Información del Paquete -->
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                <span class="inline-block text-sm text-blue-600 bg-blue-50 px-4 py-2 rounded-full font-semibold">
                                    {{ $vacacion->tipo->nombre }}
                                </span>
                                <span class="text-sm text-gray-600 font-medium">
                                    {{ $vacacion->pais }}
                                </span>
                            </div>

                            <h1 class="text-4xl font-bold mb-4 text-gray-800">{{ $vacacion->titulo }}</h1>
                            
                            <p class="text-gray-700 mb-6 leading-relaxed text-lg">
                                {{ $vacacion->descripcion }}
                            </p>
                            
                            <div class="mb-6 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                <div class="flex items-baseline gap-2 mb-2">
                                    <span class="text-5xl font-bold text-blue-600">
                                        ${{ number_format($vacacion->precio, 2) }}
                                    </span>
                                    <span class="text-gray-600">por persona</span>
                                </div>
                                <p class="text-sm text-gray-500 italic">*Precio sujeto a disponibilidad</p>
                            </div>

                            @if($vacacion->comentarios->count() > 0)
                                <div class="flex items-center mb-6 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                    <span class="text-yellow-400 text-3xl mr-2">⭐</span>
                                    <div>
                                        <span class="text-2xl font-bold text-gray-800">
                                            {{ $vacacion->comentarios->count() }}
                                        </span>
                                        <span class="text-gray-600 ml-2">comentarios de viajeros</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Botones de acción -->
                            <div class="space-y-3">
                                @if(!Auth::user()->isAdmin())
                                    @if(!$haReservado)
                                        <form action="{{ route('vacaciones.reservar', $vacacion) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-lg text-lg transition shadow-lg">
                                                Reservar Ahora
                                            </button>
                                        </form>
                                    @else
                                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-center font-semibold">
                                            Ya has reservado este paquete
                                        </div>
                                    @endif
                                @else
                                    <div class="bg-gray-100 border border-gray-300 text-gray-600 px-4 py-3 rounded-lg text-center">
                                        Los administradores no pueden reservar paquetes
                                    </div>
                                @endif

                                @if(Auth::user()->isAdmin())
                                    <div class="flex gap-2">
                                        <a href="{{ route('vacaciones.edit', $vacacion) }}" 
                                           class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-3 px-6 rounded-lg text-center transition">
                                            Editar Paquete
                                        </a>
                                        <form action="{{ route('vacaciones.destroy', $vacacion) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-6 rounded-lg transition"
                                                    onclick="return confirm('¿Estás seguro de eliminar este paquete?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Comentarios -->
                    @if(!Auth::user()->isAdmin() && $haReservado)
                        <div class="mt-12 border-t pt-8">
                            <h2 class="text-3xl font-bold mb-6 text-gray-800">Deja tu Comentario</h2>
                            <form action="{{ route('vacaciones.comentario', $vacacion) }}" method="POST" class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Tu Experiencia</label>
                                    <textarea name="texto" rows="4" 
                                              class="shadow-sm border rounded-lg w-full py-3 px-4 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                              placeholder="Comparte tu experiencia con este paquete vacacional..."
                                              required></textarea>
                                    @error('texto')
                                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition">
                                    Publicar Comentario
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Lista de Comentarios -->
                    @if($vacacion->comentarios->count() > 0)
                        <div class="mt-12 border-t pt-8">
                            <h2 class="text-3xl font-bold mb-6 text-gray-800">
                                Comentarios de Viajeros ({{ $vacacion->comentarios->count() }})
                            </h2>
                            <div class="space-y-4">
                                @foreach($vacacion->comentarios as $comentario)
                                    <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                                    {{ strtoupper(substr($comentario->user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <span class="font-bold text-gray-800 text-lg">
                                                        {{ $comentario->user->name }}
                                                    </span>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $comentario->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            @if(Auth::id() == $comentario->id_user || Auth::user()->isAdmin())
                                                <form action="{{ route('comentarios.destroy', $comentario) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-500 hover:text-red-700 text-sm font-semibold transition"
                                                            onclick="return confirm('¿Eliminar este comentario?')">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                        
                                        <p class="text-gray-700 leading-relaxed pl-15">
                                            {{ $comentario->texto }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mt-12 border-t pt-8 text-center">
                            <div class="text-6xl mb-4"></div>
                            <p class="text-gray-500 text-lg">Aún no hay comentarios para este paquete.</p>
                            @if($haReservado && !Auth::user()->isAdmin())
                                <p class="text-gray-400 text-sm mt-2">¡Sé el primero en compartir tu experiencia!</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>