<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $ticketAssigneds = Ticket::with(['user'])
            ->whereHas(
                'assigneds',
                fn ($query) => $query->where('user_id', Auth::user()->id)
            )
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $ticketStatuses = Ticket::$Status;
        $depTicketStatus = in_array($request->dept_ticket_status, Ticket::$Status)
            ? $request->dept_ticket_status : Ticket::$Status[0];
        $deptTickets = Department::selectRaw('departments.*, COUNT(department_ticket.ticket_id) as count_dept_ticket')
            ->leftJoin('department_ticket', 'department_ticket.department_id', 'departments.id')
            ->leftJoin('tickets', 'tickets.id', 'department_ticket.ticket_id')
            ->where('tickets.status', $depTicketStatus)
            ->groupBy('departments.id')
            ->orderBy('count_dept_ticket', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('ticketAssigneds', 'ticketStatuses', 'depTicketStatus', 'deptTickets'));
    }
}
