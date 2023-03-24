<?php

namespace App\View\Components\Dashboard;

use App\Models\Ticket;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class TicketTotal extends Component
{
    public $dateStart;
    public $dateEnd;
    public $dateStartLastM;
    public $dateEndLastM;
    public $tickets = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {

        $this->dateStart = Carbon::now()->startOfMonth();
        $this->dateEnd = Carbon::now()->endOfDay();
        $this->dateStartLastM = Carbon::now()->subMonth()->startOfMonth();
        $this->dateStartLastM = Carbon::now()->subMonth()->endOfMonth();

        $this->tickets['requested'] = Ticket::where('status', '!=', Ticket::$Status[3])
            ->user();
        $this->tickets['assigned'] = Ticket::where('status', '!=', Ticket::$Status[3])
            ->whereHas(
                'assigneds', 
                fn ($q) => $q->when(!Auth::user()->is_sadmin,
                    fn ($query) => $query->where('user_id', Auth::user()->id)
                )
            );

        // Department
        $this->tickets['requested_department'] = Ticket::where('status', '!=', Ticket::$Status[3])
            ->join('department_user', 'department_user.user_id', 'tickets.user_id')
            ->whereIn('department_user.department_id', Auth::user()->departments->pluck('id')->toArray());
        $this->tickets['assigned_department'] = Ticket::where('status', '!=', Ticket::$Status[3])
            ->whereHas(
                'departments',
                fn ($query) =>
                $query->whereIn('id', Auth::user()->departments->pluck('id')->toArray())
            );

        foreach ($this->tickets as $idx => $ticket) {
            $this->tickets[$idx] = (clone $ticket)
                ->whereBetween('created_at', [$this->dateStart, $this->dateEnd])
                ->count();

            $this->tickets[$idx . '_lastmonth'] = (clone $ticket)
                ->whereBetween('created_at', [$this->dateStartLastM, $this->dateStartLastM])
                ->count();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.ticket-total');
    }
}
