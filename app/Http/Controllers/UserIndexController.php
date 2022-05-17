<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserIndexController
{
    public function __invoke()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('name', 'LIKE', "%{$value}%")
                    ->orWhere('email', 'LIKE', "%{$value}%")
                    ->orWhere('password', 'LIKE', "%{$value}%");
            });
        });

        $users = QueryBuilder::for(User::class)
            ->allowedFields(['id', 'name'])
            ->defaultSort('name')
            ->allowedSorts(['name', 'email', 'password'])
            ->allowedFilters(['name', 'email', 'password', $globalSearch])
            ->paginate()
            ->withQueryString();

        return Inertia::render('Users/Index', [
            'users' => $users,
        ])->table(function (InertiaTable $table) {
            $table->addSearchRows([
                'name' => 'Name',
                'email' => 'Email address',
            ])->addFilter('password', 'Password', [
                'en' => 'Engels',
                'nl' => 'Nederlands',
            ])->addColumns([
                'email' => 'Email address',
                'password' => 'Password',
            ]);
        });
    }
}
