<x-app-layout>
    <div class="mb-3">
        <a href="{{ route('tickets.create') }}" class="btn btn-gray-800 d-inline-flex align-items-center">
            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            New Ticket
        </a>
    </div>
    <x-dashboard.ticket-total />
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h2 class="fs-5 fw-bold mb-0">Assigned Ticket</h2>
                                </div>
                                <div class="col text-end">
                                    <a href="{{ route('tickets.index', ['type' => 'assigned']) }}" class="btn btn-sm btn-primary">See all</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-bottom" scope="col">Code</th>
                                        <th class="border-bottom" scope="col">Title</th>
                                        <th class="border-bottom" scope="col">Priority</th>
                                        <th class="border-bottom" scope="col">Status</th>
                                        <th class="border-bottom" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ticketAssigneds as $ticketAssigned)
                                    <tr>
                                        <td>{{ $ticketAssigned->code }}</td>
                                        <td>{{ $ticketAssigned->title }}</td>
                                        <td>
                                            <x-ticket.priority :value="$ticketAssigned->priority" />
                                        </td>
                                        <td>
                                            <x-ticket.status :value="$ticketAssigned->status" />
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modal-detail" data-detail='@json([' code'=> $ticketAssigned->code])'>
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <a href="{{ route('tickets.show', $ticketAssigned->code) }}" class="btn btn-info btn-sm mb-1">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="col-12 px-0 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                        <h2 class="fs-5 fw-bold mb-0">Dept Ticket Status <br> <x-ticket.status :value="$depTicketStatus" /></h2>
                        <div class="dropdown">
                            <button class="btn btn-gray-50 dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Status
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                @foreach ($ticketStatuses as $tStatus)
                                    <li><a class="dropdown-item" href="{{ Request::fullUrlWithQuery(['dept_ticket_status' => $tStatus]) }}">{{ ucwords(str_replace('_', ' ', $tStatus)) }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach ($deptTickets as $dTicket)
                            <div class="d-flex align-items-center justify-content-between border-bottom pb-3">
                                <div>
                                    <div class="h6 mb-0 d-flex align-items-center">
                                        <span class="text-gray-500 me-2">#{{ $loop->iteration }}</span>
                                        {{ $dTicket->name }}
                                    </div>
                                </div>
                                <div>
                                    <a href="#" class="d-flex align-items-center fw-bold">
                                        {{ number_format($dTicket->count_dept_ticket) }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-ticket.detail :title="'Detail Ticket'" />

</x-app-layout>