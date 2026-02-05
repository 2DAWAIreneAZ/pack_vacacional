<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vacacion;

class VacacionPolicy
{
    /**
     * Determinar si el usuario puede ver cualquier paquete vacacional.
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver la lista
    }

    /**
     * Determinar si el usuario puede ver un paquete vacacional específico.
     */
    public function view(User $user, Vacacion $vacacion): bool
    {
        return true; // Todos pueden ver los detalles
    }

    /**
     * Determinar si el usuario puede crear paquetes vacacionales.
     * Solo admin y advanced pueden crear.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isAdvanced();
    }

    /**
     * Determinar si el usuario puede actualizar un paquete vacacional.
     * Solo admin puede editar cualquier paquete.
     * Advanced solo puede editar los que él creó (si implementas createdBy).
     */
    public function update(User $user, Vacacion $vacacion): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determinar si el usuario puede eliminar un paquete vacacional.
     * Solo admin puede eliminar.
     */
    public function delete(User $user, Vacacion $vacacion): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determinar si el usuario puede restaurar un paquete vacacional.
     */
    public function restore(User $user, Vacacion $vacacion): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determinar si el usuario puede eliminar permanentemente un paquete vacacional.
     */
    public function forceDelete(User $user, Vacacion $vacacion): bool
    {
        return $user->isAdmin();
    }
}