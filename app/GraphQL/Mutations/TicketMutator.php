<?php

namespace App\GraphQL\Mutations;

use App\Ticket;

class TicketMutator
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue
     * @param  mixed[]  $args
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context 
     * @return mixed
     */
    public function open($_, array $args)
    {
        return Ticket::open($args['input']);
    }

    public function assign($_, array $args)
    {
        $ticket = Ticket::find($args['id']);
        return $ticket->assign($args['input']);
    }
}