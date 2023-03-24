<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function assignUser(User $user, Ticket $ticket): bool
    {
        return in_array($ticket->status, [Ticket::$Status[0], Ticket::$Status[1]]) || $user->is_sadmin;
    }

    public function user(User $user, Ticket $ticket): bool
    {
        return $user->id == $ticket->user_id || $user->is_sadmin;
    }

    public function detail(User $user, Ticket $ticket): bool
    {
        return $ticket->detail()->exists() || $user->is_sadmin;
    }

    public function departments(User $user, Ticket $ticket): bool
    {
        return ($ticket->departments->whereIn('id', $user->departments->pluck('id')->toArray())->first() 
            ? true : false)
            || $user->is_sadmin;
    }
}
