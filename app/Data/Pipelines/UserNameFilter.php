<?php
namespace App\Data\Pipelines;
use Illuminate\Database\Eloquent\Builder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UserNameFilter
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(Builder $query, $next)
    {
        if (request()->has('name')) {
            $query->where('name',  'LIKE', '%' . request()->get('name') . '%');
        }

        return $next($query);
    }
}
