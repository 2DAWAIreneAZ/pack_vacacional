<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentario';

    protected $fillable = [
        'id_user',
        'id_vacacion',
        'texto',
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