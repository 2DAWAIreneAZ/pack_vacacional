<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    protected $table = 'tipo';

    protected $fillable = [
        'nombre',
    ];

    // Relación con vacaciones
    public function vacaciones()
    {
        return $this->hasMany(Vacacion::class, 'id_tipo');
    }
}