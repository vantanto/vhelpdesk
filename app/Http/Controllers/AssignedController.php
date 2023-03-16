<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class AssignedController extends Controller
{
    public function update(Request $request, $code)
    {
        $ticket = Ticket::detail()->where('code', $code)->firstOrFail();
        $ticket->assigneds()->sync($request->assigned_users);
        return response()->json(['status' => 'success', 'msg' => 'Assigned Users Successfully Updated.']);
    }
}
