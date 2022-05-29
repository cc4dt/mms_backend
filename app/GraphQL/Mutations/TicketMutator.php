<?php

namespace App\GraphQL\Mutations;

use App\Models\Ticket;
use App\Exceptions\CustomException;
use Gate;
use Log;

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
        $input = $args['input'];
        
        if(Gate::denies('create', [Ticket::class, $input['client_side']]))
            throw new CustomException(__("You are not authorized to do this"), __("forbidden"));

        return Ticket::open($input);
    }

    public function assign($_, array $args)
    {
        $ticket = Ticket::find($args['id']);
        if(!$ticket->can_assign)
            throw new CustomException(__("You are not authorized to do this"), __("forbidden"));
        
        return $ticket->assign($args['input']);
    }

    public function receive($_, array $args)
    {
        $ticket = Ticket::find($args['id']);
        if(Gate::denies('receive', $ticket))
            throw new CustomException(__("You are not authorized to do this"), __("forbidden"));
        
        return $ticket->receive($args['input']);
    }

    public function client_approval($_, array $args)
    {
        $ticket = Ticket::find($args['id']);
        if(Gate::denies('client-feedback', $ticket))
            throw new CustomException(__("You are not authorized to do this"), __("forbidden"));
        
        return $ticket->client_approval($args['input']);
    }

    public function approval($_, array $args)
    {
        $ticket = Ticket::find($args['id']);
        if(Gate::denies('approval', $ticket))
            throw new CustomException(__("You are not authorized to do this"), __("forbidden"));
        
        return $ticket->approval($args['input']);
    }
    
}