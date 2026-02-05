<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $query = Vacacion::with(['tipo', 'fotos', 'comentarios']);

        // Búsqueda
        if ($request->has('search') && $request->search != '') {
            $query->where('destino', 'like', '%' . $request->search . '%')
                  ->orWhere('descripcion', 'like', '%' . $request->search . '%');
        }

        // Filtro por tipo
        if ($request->has('tipo') && $request->tipo != '') {
            $query->where('id_tipo', $request->tipo);
        }

        $vacaciones = $query->orderBy('created_at', 'desc')->paginate(12);
        $tipos = Tipo::all();

        return view('shop.index', ['vacaciones' => $vacaciones, 'tipos' => $tipos]);
    }

    /**
     * Display the specified vacation package.
     */
    public function show(Vacacion $vacacion)
    {
        $vacacion->load(['tipo', 'fotos', 'comentarios.user', 'reservas']);
        
        return view('shop.show', ['vacacion' => $vacacion]);
    }

    /**
     * Make a reservation for the vacation package.
     */
    public function reservar(Vacacion $vacacion)
    {
        // Verificar si el usuario ya tiene una reserva para este paquete
        $reservaExistente = Reserva::where('id_user', Auth::id())
            ->where('id_vacacion', $vacacion->id)
            ->first();

        if ($reservaExistente) {
            return redirect()->back()->with('success', '¡Ya tienes una reserva para este paquete!');
        }

        // Crear la reserva
        Reserva::create([
            'id_user' => Auth::id(),
            'id_vacacion' => $vacacion->id,
            'fecha_reserva' => now(),
        ]);

        return redirect()->route('shop.show', $vacacion)
            ->with('success', '¡Reserva realizada con éxito! Te esperamos en tu próxima aventura.');
    }

    /**
     * Add a comment/rating to the vacation package.
     */
    public function comentario(Request $request, Vacacion $vacacion)
    {
        $request->validate([
            'valoracion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        Comentario::create([
            'id_user' => Auth::id(),
            'id_vacacion' => $vacacion->id,
            'valoracion' => $request->valoracion,
            'comentario' => $request->comentario,
        ]);

        return redirect()->route('shop.show', $vacacion)
            ->with('success', '¡Gracias por tu valoración!');
    }
}
