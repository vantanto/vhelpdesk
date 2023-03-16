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

    public function user(User $user, Ticket $ticket): bool
    {
        return $user->id == $ticket->user_id;
    }

    public function detail(User $user, Ticket $ticket): bool
    {
        return $ticket->detail()->exists();
    }

    public function departments(User $user, Ticket $ticket): bool
    {
        return $ticket->departments->whereIn('id', $user->departments->pluck('id')->toArray())->first() 
            ? true : false;
    }
}
