<?php

namespace App\View\Components;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\View\View;

class TicketIndex extends Component
{
    public string $type;
    public array $totals = [
        'requested' => 0,
        'assigned' => 0,
        'unassigned' => 0,
    ];

    public function __construct()
    {
        $this->type = request()->input('type') ?? 'requested';

        $this->totals['requested'] = Ticket::whereIn('status', [Ticket::$Status[0], Ticket::$Status[1]])
            ->user()
            ->count();
        $this->totals['assigned'] = Ticket::whereIn('status', [Ticket::$Status[0], Ticket::$Status[1]])
            ->whereHas(
                'assigneds', 
                fn ($q) => $q->when(!Auth::user()->is_sadmin, 
                    fn ($query) => $query->where('user_id', Auth::user()->id)
                )
            )
            ->count();
        $this->totals['unassigned'] = Ticket::whereIn('status', [Ticket::$Status[0], Ticket::$Status[1]])
            ->doesntHave('assigneds')
            ->when(!Auth::user()->is_sadmin, fn ($q) =>
                $q->where('user_id', '!=', Auth::user()->id)
                    ->whereHas(
                        'departments',
                        fn ($query) => $query->whereIn('id', Auth::user()->departments->pluck('id')->toArray())
                    )
            )
            ->count();
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('ticket.index');
    }
}
