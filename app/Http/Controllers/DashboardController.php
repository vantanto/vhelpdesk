<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
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

    public function search(Request $request)
    {
        $search = $request->search;
        $count = 0;
        $menuData = [];

        if (!empty($search)) {
            $menuData['ticket'] = Ticket::with('category')
                ->where('code', 'like', '%'.$search.'%')
                ->orWhere('title', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhere('priority', 'like', '%'.$search.'%')
                ->orWhere('status', 'like', '%'.$search.'%')
                ->orWhereHas('category', fn($query) => $query->where('name', 'like', '%'.$search.'%'));

            $menuData['department'] = Department::where('name', 'like', '%'.$search.'%');
            $menuData['user'] = User::where('name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%');
            $menuData['category'] = Category::where('name', 'like', '%'.$search.'%');

            foreach ($menuData as $menu=>$data) {
                $menuData[$menu] = $data->paginate(2, ['*'], $menu);
                $count += $menuData[$menu]->total();
            }
        }

        return view('search', compact('count', 'menuData'));
    }
}
