<?php

namespace App\GraphQL\Mutations;

use App\Ticket;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $input['number'] = Carbon::now()->timestamp;
        $input['status'] = 'open';
        $input['created_by_id'] = Auth::id();
        $input['updated_by_id'] = Auth::id();

        return Ticket::create($input);
    }

    public function assign($_, array $args)
    {
        $ticket = Ticket::find($args['id']);

        $input = $args['input'];
        $input['updated_by_id'] = Auth::id();
        $input['status'] = 'waiting_for_access';

        if ($ticket->update($input)) {
            return $ticket;
        } else {
            return null;
        }
    }
}