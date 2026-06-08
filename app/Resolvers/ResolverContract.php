<?php

namespace App\Resolvers;

use Closure;

interface ResolverContract
{
    public function handle(array $payload, Closure $next);
}
