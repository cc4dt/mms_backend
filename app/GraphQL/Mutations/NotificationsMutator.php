<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;

class NotificationsMutator
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function asRead($_, array $args)
    {
        Auth::user()->unreadNotifications->markAsRead();
        return true;

    }
}
