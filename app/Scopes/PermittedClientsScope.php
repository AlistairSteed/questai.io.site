<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PermittedClientsScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (! auth()->check()) {
            return;
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($user->canAccessAllClients()) {
            return;
        }

        $builder->whereIn($model->getKeyName(), $user->allowedClientIds());
    }
}