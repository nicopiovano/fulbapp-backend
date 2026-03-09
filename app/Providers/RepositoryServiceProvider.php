<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\MatchRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\MatchRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(MatchRepositoryInterface::class, MatchRepository::class);
    }
}
