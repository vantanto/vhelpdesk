<x-app-layout>

    <div class="mb-3">
        <a href="{{ route('tickets.create') }}" class="btn btn-gray-800 d-inline-flex align-items-center">
            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            New Ticket
        </a>
    </div>

    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="nav-wrapper position-relative">
                <ul class="nav nav-pills nav-fill flex-column flex-sm-row">
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 @if($type == 'requested') active @endif" 
                            href="{{ route('tickets.index', ['type' => 'requested']) }}">
                            Requested Ticket @if($totals['requested'] > 0) ({{ $totals['requested'] }}) @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 @if($type == 'assigned') active @endif" 
                            href="{{ route('tickets.index', ['type' => 'assigned']) }}">
                            Assigned Ticket @if($totals['assigned'] > 0) ({{ $totals['assigned'] }}) @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-sm-3 mb-md-0 @if($type == 'unassigned') active @endif" 
                            href="{{ route('tickets.index', ['type' => 'unassigned']) }}">
                            Unassigned Ticket @if($totals['unassigned'] > 0) ({{ $totals['unassigned'] }}) @endif
                        </a>
                    </li>
                </ul>
            </div>

            {{ $slot ?? '' }}
        </div>
    </div>

    <x-ticket.detail :title="'Detail Ticket'" />
    
</x-app-layout>