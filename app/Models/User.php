<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin() {
        return $this->rol === 'admin';
    }

    public function isAdvanced() {
        return $this->rol === 'advanced';
    }

    public function isNormal() {
        return $this->rol === 'normal';
    }

    // Relaciones
    public function reservas() {
        return $this->hasMany(Reserva::class, 'id_user');
    }

    public function comentarios() {
        return $this->hasMany(Comentario::class, 'id_user');
    }

    public function vacaciones() {
        return $this->belongsToMany(Vacacion::class, 'reserva', 'id_user', 'id_vacacion')->withTimestamps();
    }
}