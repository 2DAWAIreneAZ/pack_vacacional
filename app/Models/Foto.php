<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'foto';

    protected $fillable = [
        'id_vacacion',
        'ruta',
    ];

    // Relación con vacación
    public function vacacion()
    {
        return $this->belongsTo(Vacacion::class, 'id_vacacion');
    }
}