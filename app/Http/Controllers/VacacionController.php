<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use App\Models\Tipo;
use App\Models\Foto;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class VacacionController extends Controller
{
    /**
     * Mostrar listado de paquetes vacacionales con filtros y paginación
     */
    public function index(Request $request)
    {
        $query = Vacacion::with(['tipo', 'fotos', 'comentarios.user']);

        // Filtro por búsqueda (título o descripción)
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('titulo', 'like', '%' . $request->search . '%')
                  ->orWhere('descripcion', 'like', '%' . $request->search . '%')
                  ->orWhere('pais', 'like', '%' . $request->search . '%');
            });
        }

        // Filtro por tipo
        if ($request->has('tipo') && $request->tipo != '') {
            $query->where('id_tipo', $request->tipo);
        }

        // Filtro por país
        if ($request->has('pais') && $request->pais != '') {
            $query->where('pais', 'like', '%' . $request->pais . '%');
        }

        // Filtro por rango de precio
        if ($request->has('precio_min') && $request->precio_min != '') {
            $query->where('precio', '>=', $request->precio_min);
        }
        if ($request->has('precio_max') && $request->precio_max != '') {
            $query->where('precio', '<=', $request->precio_max);
        }

        // Ordenamiento
        if ($request->has('orden')) {
            switch ($request->orden) {
                case 'precio_asc':
                    $query->orderBy('precio', 'asc');
                    break;
                case 'precio_desc':
                    $query->orderBy('precio', 'desc');
                    break;
                case 'titulo_asc':
                    $query->orderBy('titulo', 'asc');
                    break;
                case 'titulo_desc':
                    $query->orderBy('titulo', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $vacaciones = $query->paginate(12)->withQueryString();
        $tipos = Tipo::all();

        return view('vacacion.index', ['vacaciones' => $vacaciones, 'tipos' => $tipos]);
    }

    /**
     * Mostrar formulario de creación (solo admin y advanced)
     */
    public function create()
    {
        $this->authorize('create', Vacacion::class);
        $tipos = Tipo::all();
        return view('vacacion.create', ['tipos' => $tipos]);
    }

    /**
     * Almacenar nuevo paquete vacacional con try-catch
     */
    public function store(Request $request)
    {
        $this->authorize('create', Vacacion::class);

        // Validación
        $validated = $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'id_tipo' => 'required|exists:tipo,id',
            'pais' => 'required|string|max:100',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Crear la vacación
            $vacacion = Vacacion::create($validated);

            // Procesar y guardar las fotos
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $ruta = $foto->store('vacacion', 'public');
                    Foto::create([
                        'id_vacacion' => $vacacion->id,
                        'ruta' => $ruta,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('vacacion.index')
                           ->with('success', '¡Paquete vacacional creado exitosamente!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error al crear el paquete: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar detalles de un paquete vacacional
     */
    public function show(Vacacion $vacacion)
    {
        $vacacion->load(['tipo', 'fotos', 'comentarios.user']);
        
        // Verificar si el usuario actual ha reservado este paquete
        $haReservado = false;
        if (auth()->check()) {
            $haReservado = $vacacion->estaReservadoPor(auth()->id());
        }

        return view('vacacion.show', ['vacacion' => $vacacion, 'haReservado' => $haReservado]);
    }

    /**
     * Mostrar formulario de edición (solo admin)
     */
    public function edit(Vacacion $vacacion)
    {
        $this->authorize('update', $vacacion);
        $tipos = Tipo::all();
        $vacacion->load('fotos');
        
        return view('vacacion.edit', ['vacacion'  => $vacacion, 'tipos' => $tipos]);
    }

    /**
     * Actualizar paquete vacacional con try-catch
     */
    public function update(Request $request, Vacacion $vacacion)
    {
        $this->authorize('update', $vacacion);

        $validated = $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'id_tipo' => 'required|exists:tipo,id',
            'pais' => 'required|string|max:100',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'fotos_eliminar' => 'nullable|array',
            'fotos_eliminar.*' => 'exists:foto,id',
        ]);

        try {
            DB::beginTransaction();

            // Actualizar datos de la vacación
            $vacacion->update($validated);

            // Eliminar fotos marcadas para eliminación
            if ($request->has('fotos_eliminar')) {
                foreach ($request->fotos_eliminar as $fotoId) {
                    $foto = Foto::find($fotoId);
                    if ($foto && $foto->id_vacacion == $vacacion->id) {
                        // Eliminar archivo si es local
                        if (!str_starts_with($foto->ruta, 'http') && Storage::disk('public')->exists($foto->ruta)) {
                            Storage::disk('public')->delete($foto->ruta);
                        }
                        $foto->delete();
                    }
                }
            }

            // Agregar nuevas fotos
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $ruta = $foto->store('vacaciones', 'public');
                    Foto::create([
                        'id_vacacion' => $vacacion->id,
                        'ruta' => $ruta,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('vacacion.index')
                           ->with('success', '¡Paquete vacacional actualizado exitosamente!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Error al actualizar el paquete: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar paquete vacacional con try-catch (solo admin)
     */
    public function destroy(Vacacion $vacacion)
    {
        $this->authorize('delete', $vacacion);

        try {
            DB::beginTransaction();

            // Eliminar todas las fotos asociadas
            foreach ($vacacion->fotos as $foto) {
                // Eliminar archivo si es local
                if (!str_starts_with($foto->ruta, 'http') && Storage::disk('public')->exists($foto->ruta)) {
                    Storage::disk('public')->delete($foto->ruta);
                }
                $foto->delete();
            }

            // Eliminar la vacación (las reservas y comentarios se eliminan por CASCADE)
            $vacacion->delete();

            DB::commit();

            return redirect()->route('vacacion.index')
                           ->with('success', '¡Paquete vacacional eliminado exitosamente!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('vacacion.index')
                           ->with('error', 'Error al eliminar el paquete: ' . $e->getMessage());
        }
    }

    /**
     * Reservar paquete vacacional (solo usuarios normales)
     */
    public function reservar(Vacacion $vacacion)
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->back()
                           ->with('error', '¡Los administradores no pueden reservar paquetes!');
        }

        try {
            // Verificar si ya tiene una reserva
            if ($vacacion->estaReservadoPor(auth()->id())) {
                return redirect()->back()
                               ->with('error', '¡Ya has reservado este paquete vacacional!');
            }

            $vacacion->reservas()->create([
                'id_user' => auth()->id(),
            ]);

            return redirect()->route('vacacion.show', $vacacion)
                           ->with('success', '¡Reserva realizada exitosamente! Paquete: ' . $vacacion->titulo);

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error al realizar la reserva: ' . $e->getMessage());
        }
    }

    /**
     * Agregar comentario (solo usuarios que hayan reservado)
     */
    public function agregarComentario(Request $request, Vacacion $vacacion)
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->back()
                           ->with('error', '¡Los administradores no pueden comentar!');
        }

        // Verificar que el usuario haya reservado este paquete
        if (!$vacacion->estaReservadoPor(auth()->id())) {
            return redirect()->back()
                           ->with('error', '¡Solo puedes comentar paquetes que hayas reservado!');
        }

        $validated = $request->validate([
            'texto' => 'required|string|max:1000',
        ]);

        try {
            Comentario::updateOrCreate(
                [
                    'id_vacacion' => $vacacion->id,
                    'id_user' => auth()->id(),
                ],
                [
                    'texto' => $validated['texto'],
                ]
            );

            return redirect()->back()
                           ->with('success', '¡Comentario agregado exitosamente!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error al agregar el comentario: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar comentario (solo el propio usuario puede eliminar sus comentarios)
     */
    public function eliminarComentario(Comentario $comentario)
    {
        // Verificar que el comentario pertenece al usuario actual
        if ($comentario->id_user !== auth()->id() && !auth()->user()->isAdmin()) {
            return redirect()->back()
                           ->with('error', '¡No tienes permiso para eliminar este comentario!');
        }

        try {
            $comentario->delete();

            return redirect()->back()
                           ->with('success', '¡Comentario eliminado exitosamente!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error al eliminar el comentario: ' . $e->getMessage());
        }
    }
}