<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Paquete Vacacional</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
                            ✅ {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                            ❌ {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('vacaciones.update', $vacacion) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Título -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Título del Paquete *
                            </label>
                            <input type="text" 
                                   name="titulo" 
                                   value="{{ old('titulo', $vacacion->titulo) }}" 
                                   class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titulo') border-red-500 @enderror" 
                                   required>
                            @error('titulo')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Descripción Completa *
                            </label>
                            <textarea name="descripcion" 
                                      rows="6" 
                                      class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descripcion') border-red-500 @enderror" 
                                      required>{{ old('descripcion', $vacacion->descripcion) }}</textarea>
                            @error('descripcion')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo y Precio -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Tipo -->
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    Tipo de Vacación *
                                </label>
                                <select name="id_tipo" 
                                        class="shadow border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('id_tipo') border-red-500 @enderror" 
                                        required>
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->id }}" 
                                                {{ old('id_tipo', $vacacion->id_tipo) == $tipo->id ? 'selected' : '' }}>
                                            {{ $tipo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_tipo')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Precio -->
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    Precio por Persona ($) *
                                </label>
                                <input type="number" 
                                       step="0.01" 
                                       name="precio" 
                                       value="{{ old('precio', $vacacion->precio) }}" 
                                       class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('precio') border-red-500 @enderror" 
                                       required>
                                @error('precio')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- País -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                País de Destino *
                            </label>
                            <input type="text" 
                                   name="pais" 
                                   value="{{ old('pais', $vacacion->pais) }}" 
                                   class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pais') border-red-500 @enderror" 
                                   required>
                            @error('pais')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fotos Actuales -->
                        @if($vacacion->fotos->count() > 0)
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    Fotos Actuales
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                    @foreach($vacacion->fotos as $foto)
                                        <div class="relative group">
                                            <img src="{{ $foto->ruta }}" 
                                                 alt="Foto {{ $loop->iteration }}" 
                                                 class="w-full h-32 object-cover rounded-lg shadow-md">
                                            <label class="absolute top-2 left-2 bg-white bg-opacity-90 rounded px-2 py-1 text-xs font-semibold flex items-center cursor-pointer hover:bg-red-100 transition">
                                                <input type="checkbox" 
                                                       name="fotos_eliminar[]" 
                                                       value="{{ $foto->id }}"
                                                       class="mr-1">
                                                Eliminar
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-gray-600 text-xs mt-2">
                                    Marca las fotos que deseas eliminar
                                </p>
                            </div>
                        @endif

                        <!-- Agregar Nuevas Fotos -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Agregar Nuevas Fotos (Opcional)
                            </label>
                            <input type="file" 
                                   name="fotos[]" 
                                   multiple
                                   accept="image/*" 
                                   class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fotos.*') border-red-500 @enderror"
                                   onchange="previewNewImages(event)">
                            <p class="text-gray-600 text-xs mt-1">
                                Puedes agregar más imágenes - JPEG, PNG, GIF, máximo 2MB cada una
                            </p>
                            @error('fotos.*')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                            
                            <!-- Preview de nuevas imágenes -->
                            <div id="newImagePreviewContainer" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3 hidden"></div>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-between pt-4 border-t">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition shadow-lg">
                                Actualizar Paquete
                            </button>
                            <a href="{{ route('vacaciones.show', $vacacion) }}" 
                               class="text-gray-600 hover:text-gray-800 font-semibold">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewNewImages(event) {
            const container = document.getElementById('newImagePreviewContainer');
            container.innerHTML = '';
            
            const files = event.target.files;
            
            if (files.length > 0) {
                container.classList.remove('hidden');
                
                Array.from(files).forEach((file, index) => {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-full h-32 object-cover rounded-lg shadow-md border-2 border-green-300';
                        
                        const label = document.createElement('div');
                        label.className = 'absolute top-1 left-1 bg-green-500 text-white text-xs px-2 py-1 rounded';
                        label.textContent = `Nueva ${index + 1}`;
                        
                        div.appendChild(img);
                        div.appendChild(label);
                        container.appendChild(div);
                    }
                    
                    reader.readAsDataURL(file);
                });
            } else {
                container.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>