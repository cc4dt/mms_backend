<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Auth;
use App\User;

class UserQuery
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function usersById($_, array $args)
    {
        return User::whereIn('id', $args["ids"])->get();
    }

    public function teamleaders($_, array $args)
    {
        return User::teamleaders();
    }
}