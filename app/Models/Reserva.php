<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reserva';

    protected $fillable = [
        'id_user',
        'id_vacacion',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relación con vacación
    public function vacacion()
    {
        return $this->belongsTo(Vacacion::class, 'id_vacacion');
    }
}