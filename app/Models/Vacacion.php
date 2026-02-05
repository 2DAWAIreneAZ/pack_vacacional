<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacacion extends Model
{
    use HasFactory;

    protected $table = 'vacacion';

    protected $fillable = [
        'titulo',
        'descripcion',
        'precio',
        'id_tipo',
        'pais',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];

    // Relación con tipo
    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'id_tipo');
    }

    // Relación con fotos
    public function fotos()
    {
        return $this->hasMany(Foto::class, 'id_vacacion');
    }

    // Relación con reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_vacacion');
    }

    // Relación con comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_vacacion');
    }

    // Relación con usuarios que han reservado
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'reserva', 'id_vacacion', 'id_user')
                    ->withTimestamps();
    }

    // Método para obtener la primera foto o una imagen por defecto
    public function getPrimeraFotoAttribute()
    {
        $primeraFoto = $this->fotos()->first();
        return $primeraFoto ? $primeraFoto->ruta : 'https://placehold.co/600x400';
    }

    // Método para verificar si un usuario ha reservado este paquete
    public function estaReservadoPor($userId)
    {
        return $this->reservas()->where('id_user', $userId)->exists();
    }
}