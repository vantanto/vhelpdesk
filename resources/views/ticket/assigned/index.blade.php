<x-ticket-index>
    <div class="table-responsive">
        <table class="table table-centered table-nowrap mb-0 rounded">
            <thead class="thead-light">
                <tr>
                    <th class="border-0 rounded-start">Code</th>
                    <th class="border-0">Title</th>
                    <th class="border-0">Priority</th>
                    <th class="border-0">Status</th>
                    <th class="border-0">Due Date</th>
                    <th class="border-0">Requested</th>
                    <th class="border-0 rounded-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->code }}</td>
                        <td>{{ $ticket->title }}</td>
                        <td><x-ticket.priority :value="$ticket->priority" /></td>
                        <td><x-ticket.status :value="$ticket->status" /></td>
                        <td>{{ $ticket->due_date?->format('d/m/Y H:i') ?? '-' }}</td>
                        <td>
                            {{ $ticket->user->name }}
                            <br>{{ $ticket->created_at->format("d/m/Y H:i") }}
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modal-detail"
                                data-detail='@json(['code' => $ticket->code])'>
                                <i class="fa fa-eye"></i>
                            </button>
                            <a href="{{ route('tickets.show', $ticket->code) }}" class="btn btn-info btn-sm mb-1">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tickets->withQueryString()->links() }}
    </div>
</x-ticket-index>