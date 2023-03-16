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

    <x-modal.detail :title="'Detail Ticket'" />

    @push('scripts')
        <script>
            $(document).ready(function() {
                getDataDetail("modal-detail", "{{ route('tickets.detail') }}", function(result) {
                    if (result.status == 'success') {
                        const data = result.data;
                        $("#modal-detail .modal-body").html(`
                            <table class="table table-sm table-borderless mb-0">
                                <colgroup>
                                    <col class="col-md-4">
                                    <col class="col-md-8">
                                </colgroup>
                                <tr>
                                    <td>Code</td>
                                    <td><strong>`+data.code+`</strong></td>
                                </tr>
                                <tr>
                                    <td>Title</td>
                                    <td>`+data.title+`</td>
                                </tr>
                                <tr>
                                    <td>Priority</td>
                                    <td>`+ticketPriority(data.priority)+`</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>`+ticketStatus(data.status)+`</td>
                                </tr>
                                <tr>
                                    <td>Category</td>
                                    <td>`+(data.category?.name ?? '-')+`</td>
                                </tr>
                                <tr>
                                    <td>Due Date</td>
                                    <td>`+(data.due_date ? moment(data.due_date, 'YYYY-MM-DD HH:mm:ss').format('DD/MM/YYYY HH:mm') : '-')+`</td>
                                </tr>
                                <tr>
                                    <td>Department</td>
                                    <td>`+(data.departments.length > 0 ? data.departments.map((item) => item.name).join(', ') : '-')+`</td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>`+data.description+`</td>
                                </tr>
                                <tr>
                                    <td>Requested By</td>
                                    <td>`+data.user.name+`</td>
                                </tr>
                                <tr>
                                    <td>Requested Date</td>
                                    <td>`+(data.created_at ? moment(data.created_at, 'YYYY-MM-DD HH:mm:ss').format('DD/MM/YYYY HH:mm') : '-')+`</td>
                                </tr>
                                <tr>
                                    <td colspan="2">`+(data.files ? data.files.length + ' files attachment' : '')+`</td>
                                </tr>
                            </table>
                        `);
                    }
                });
            });
        </script>
    @endpush
    
</x-app-layout>