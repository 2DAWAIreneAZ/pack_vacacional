<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">+ Crear Nuevo Paquete Vacacional</h2>
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

                    <form action="{{ route('vacaciones.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Título -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Título del Paquete *
                            </label>
                            <input type="text" 
                                   name="titulo" 
                                   value="{{ old('titulo') }}" 
                                   class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('titulo') border-red-500 @enderror" 
                                   placeholder="Ej: Paraíso Caribeño en Cancún" 
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
                                      placeholder="Describe el paquete vacacional con todos los detalles..."
                                      required>{{ old('descripcion') }}</textarea>
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
                                    <option value="">-- Selecciona un tipo --</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->id }}" {{ old('id_tipo') == $tipo->id ? 'selected' : '' }}>
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
                                       value="{{ old('precio') }}" 
                                       class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('precio') border-red-500 @enderror" 
                                       placeholder="999.99" 
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
                                   value="{{ old('pais') }}" 
                                   class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pais') border-red-500 @enderror" 
                                   placeholder="Ej: México, España, Francia..." 
                                   required>
                            @error('pais')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fotos -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Fotos del Paquete (Opcional)
                            </label>
                            <input type="file" 
                                   name="fotos[]" 
                                   multiple
                                   accept="image/*" 
                                   class="shadow appearance-none border rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fotos.*') border-red-500 @enderror"
                                   onchange="previewImages(event)">
                            <p class="text-gray-600 text-xs mt-1">
                                📷 Puedes subir múltiples imágenes - JPEG, PNG, GIF, máximo 2MB cada una
                            </p>
                            @error('fotos.*')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                            
                            <!-- Preview de imágenes -->
                            <div id="imagePreviewContainer" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3 hidden"></div>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-between pt-4 border-t">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition shadow-lg">
                                ✅ Crear Paquete Vacacional
                            </button>
                            <a href="{{ route('vacaciones.index') }}" 
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
        function previewImages(event) {
            const container = document.getElementById('imagePreviewContainer');
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
                        img.className = 'w-full h-32 object-cover rounded-lg shadow-md border-2 border-gray-200';
                        
                        const label = document.createElement('div');
                        label.className = 'absolute top-1 left-1 bg-blue-500 text-white text-xs px-2 py-1 rounded';
                        label.textContent = `Foto ${index + 1}`;
                        
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