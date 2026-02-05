<?php

namespace App\Providers;

use App\Models\Vacacion;
use App\Policies\VacacionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Vacacion::class => VacacionPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}