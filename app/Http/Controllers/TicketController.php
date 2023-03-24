<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type') ?? 'requested';
        if (!in_array($type, ['requested', 'assigned', 'unassigned'])) return abort(404);

        $tickets = Ticket::orderBy('id', 'desc');

        if (!empty($request->search)) {
            $tickets->where(
                fn ($query) =>
                $query->where('code', 'like', '%' . $request->search . '%')
                    ->orWhere('title', 'like', '%' . $request->search . '%')
            );
        }
        if (!empty($request->priority)) {
            $tickets->where('priority', $request->priority);
        }
        if (!empty($request->status)) {
            $tickets->where('status', $request->status);
        }

        if ($type == 'requested') {
            $tickets->user();
        } elseif ($type == 'assigned') {
            $tickets->with(['user'])
                ->whereHas(
                    'assigneds',
                    fn ($q) => $q->when(!Auth::user()->is_sadmin, 
                        fn ($query) => $query->where('user_id', Auth::user()->id)
                    )
                );
        } elseif ($type == 'unassigned') {
            $tickets->with(['user'])
                ->doesntHave('assigneds')
                ->when(!Auth::user()->is_sadmin, fn ($q) =>
                    $q->where('user_id', '!=', Auth::user()->id)
                        ->whereHas(
                            'departments',
                            fn ($query) => $query->whereIn('id', Auth::user()->departments->pluck('id')->toArray())
                        )
                );
        }

        $tickets = $tickets->paginate();

        return view('ticket.' . $type . '.index', compact('tickets'));
    }

    public function create()
    {
        $priorities = Ticket::$Priorities;
        $categories = Category::orderBy('name')->get();
        $departments = Department::all();
        return view('ticket.create', compact('priorities', 'categories', 'departments'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'priority' => ['required', Rule::in(Ticket::$Priorities)],
            'category' => 'nullable|exists:categories,id',
            'due_date' => 'nullable|date',
            'departments.*' => 'nullable|distinct|exists:departments,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'message' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $ticket = new Ticket;
            $ticket->fill($request->only('title', 'description', 'priority', 'due_date'));
            $ticket->category_id = $request->category;
            $ticket->user_id = Auth::user()->id;
            $ticket->save();

            if (!empty($request->departments)) $ticket->departments()->attach($request->departments);

            $ticket->files = Helper::fileStoreMultiple($request->file('files'), Ticket::$FilePath . $ticket->id . '/');
            $ticket->code = $ticket->generateCode();
            $ticket->save();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Ticket Successfully Created.']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Ticket Failed Created.', 'data' => $ex->getMessage()], 500);
        }
    }

    public function detail(Request $request)
    {
        $ticket = Ticket::with(['category', 'departments', 'user'])
            ->detail()
            ->where('code', $request->code)->first();
        if ($ticket) {
            return response()->json(['status' => 'success', 'message' => 'Data Found.', 'data' => $ticket]);
        }
        return response()->json(['status' => 'error', 'message' => 'No Data Found.'], 404);
    }

    public function show(Request $request, $code)
    {
        $ticket = Ticket::with(['category', 'departments', 'user', 'assigneds'])->where('code', $code)
            ->detail()
            ->firstOrFail();
        $assignedUsers = User::query()
            ->whereHas(
                'departments',
                fn ($query) => $query->whereIn('id', $ticket->departments->pluck('id')->toArray())
            )->get();
        return view('ticket.show', compact('ticket', 'assignedUsers'));
    }

    public function edit(Request $request, $code)
    {
        $ticket = Ticket::where('code', $code)->user()->firstOrFail();
        $priorities = Ticket::$Priorities;
        $categories = Category::orderBy('name')->get();
        $departments = Department::all();
        return view('ticket.edit', compact('ticket', 'priorities', 'categories', 'departments'));
    }

    public function update(Request $request, $code)
    {
        $ticket = Ticket::where('code', $code)->user()->firstOrFail();
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'priority' => ['required', Rule::in(Ticket::$Priorities)],
            'category' => 'nullable|exists:categories,id',
            'due_date' => 'nullable|date',
            'departments.*' => 'nullable|distinct|exists:departments,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'message' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $ticket->fill($request->only('title', 'description', 'priority', 'due_date'));
            $ticket->category_id = $request->category;
            $ticket->save();

            $ticket->departments()->sync($request->departments);

            $ticket->files = Helper::fileUpdateMultiple($ticket->files, $request->files_delete, $request->file('files'), Ticket::$FilePath . $ticket->id . '/');
            $ticket->save();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Ticket Successfully Updated.']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Ticket Failed Updated.', 'data' => $ex->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $code)
    {
        $ticket = Ticket::where('code', $code)->user()->firstOrFail();
        $ticket->delete();
        return redirect()->back()->with('success', 'Ticket Successfully Deleted.');
    }

    public function statusUpdate(Request $request, $code)
    {
        $ticket = Ticket::where('code', $code)->detail()->firstOrFail();
        $validator = \Validator::make($request->all(), [
            'status' => ['required', Rule::in(Ticket::$Status)],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'message' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $ticket->status = $request->status;
            $ticket->save();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Ticket Status Successfully Updated.']);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Ticket Status Failed Updated.', 'data' => $ex->getMessage()], 500);
        }
    }
}
