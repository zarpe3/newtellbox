<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CustomerScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();
        switch ($user->user_type) {
            case 'admin':
                break;
            case 'regular':
                $builder->where('id', $user->customer_id);
                break;
        }
    }
}
