<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use Log;

class TicketPolicy
{
    use HandlesAuthorization;

    public function assgin(User $user, Ticket $ticket)
    {
        if(!$ticket->isOnStatus([TicketStatus::OPENED]))
            return false;
            
        if($ticket->client_side)
        {
            if($user->hasAbility(Ticket::CLIENT_ASSIGN))
                return true;
        }
        else if($user->hasAbility(Ticket::ASSIGN))
        {
            return true;
        }
        
        return false;
    }

    public function receive(User $user, Ticket $ticket)
    {
        if(!$ticket->isOnStatus([TicketStatus::ASSGIND, TicketStatus::WAIT_SPARE]))
            return false;

        if($ticket->client_side)
        {
            if($user->hasAbility(Ticket::CLIENT_RECEIVE))
                return true;
        }
        else if($user->hasAbility(Ticket::RECEIVE))
        {
            return true;
        }
        
        return false;
    }

    public function approval(User $user, Ticket $ticket)
    {
        if($ticket->client_side)
        {
            if($user->hasAbility(Ticket::CLIENT_APPROVAL))
                return true;
        }
        else if($user->hasAbility(Ticket::APPROVAL))
        {
            return true;
        }

        return false;
    }

    public function clientFeedback(User $user, Ticket $ticket)
    {
        if(!$ticket->isOnStatus([TicketStatus::CLOSED, TicketStatus::WAIT_CLIENT_APPROVAL]))
            return false;
        
        return $user->hasAbility(Ticket::CLIENT_FEEDBACK);
    }

    public function cancel(User $user, Ticket $ticket)
    {
        if($ticket->isOnStatus(TicketStatus::CANCELLED))
            return false;

        if($ticket->created_by_id == $user->id)
            return true;

        if($ticket->client_side)
        {
            if($user->hasAbility(Ticket::CLIENT_CANCEL))
                return true;
        }
        else if($user->hasAbility(Ticket::CANCEL))
        {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAbility(Ticket::BROWSE);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Ticket $ticket)
    {
        if($ticket->created_by_id == $user->id)
            return true;

        return $user->hasAbility(Ticket::READ);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, $clientSide=false)
    {
        if($clientSide) return $user->hasAbility(Ticket::CREATE_CLIENT_SIDE);
        return $user->hasAbility(Ticket::CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Ticket $ticket)
    {
        if($ticket->created_by_id == $user->id)
            return true;

        return $user->hasAbility(Ticket::UPDATE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Ticket $ticket)
    {
        if($ticket->created_by_id == $user->id)
            return true;

        return $user->hasAbility(Ticket::DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Ticket $ticket)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Ticket $ticket)
    {
        //
    }
}
