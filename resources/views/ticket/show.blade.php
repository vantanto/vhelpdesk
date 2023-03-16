<x-app-layout>
    @php
        $canAssignedUsers = !in_array($ticket->status, ['done', 'cancelled']) ;
    @endphp
    <div class="row">
        <div class="col-md-7">
            <div class="card card-body border-0 shadow">
                <h2 class="h5 mb-4">Detail Ticket</h2>
                <h3 class="h5 mb-3 text-center">{{ $ticket->code }}</h3>
                <table class="table table-sm table-borderless">
                    <colgroup>
                        <col class="col-md-4">
                        <col class="col-md-8">
                    </colgroup>
                    <tr>
                        <td>Title</td>
                        <td>{{ $ticket->title }}</td>
                    </tr>
                    <tr>
                        <td>Priority</td>
                        <td><x-ticket.priority :value="$ticket->priority" /></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><x-ticket.status :value="$ticket->status" /></td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>{{ $ticket->category?->name }}</td>
                    </tr>
                    <tr>
                        <td>Due Date</td>
                        <td>{{ $ticket->due_date?->format('d/m/Y H:i') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td>{!! implode('<br>', $ticket->departments->pluck('name')->toArray()) !!}</td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>{{ $ticket->description }}</td>
                    </tr>
                    <tr>
                        <td>Requested By</td>
                        <td>{{ $ticket->user->name }}</td>
                    </tr>
                    <tr>
                        <td>Requested Date</td>
                        <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">@if($ticket->files) {{ count($ticket->files) }} files attachment @endif</td>
                    </tr>
                </table>
                <div class="mx-2 mt-3">
                    @foreach ((array) $ticket->files as $file)
                        <x-file href="{{ Storage::disk('public')->url($file) }}" download="true" />
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card card-body border-0 shadow mb-3">
                <div class="text-center">
                    <x-ticket.status :value="$ticket->status" />
                </div>
                <div class="text-center">
                    @can('departments', $ticket)
                        @if($ticket->status == 'waiting')
                            <button type="button" class="btn-status-update btn bg-purple text-white m-2 mb-1"
                                value="in_progress">
                                Process
                            </button>
                        @elseif($ticket->status == 'in_progress')
                            <button type="button" class="btn-status-update btn btn-success text-white m-2 mb-1"
                                value="done">
                                Complete
                            </button>
                        @endif
                    @endcan
                    @can('user', $ticket)
                        @if($ticket->status == 'waiting' || $ticket->status == 'in_progress') 
                            <button type="button" class="btn-status-update btn btn-danger m-2 mb-1"
                                value="cancelled">
                                Cancel
                            </button>
                        @endif
                    @endcan
                </div>
            </div>
            <div class="card card-body border-0 shadow">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h6 mb-3 text-center">Assigned Users</h2>
                    @if ($canAssignedUsers)
                        <button class="btn btn-warning btn-icon-only btn-sm"
                            data-bs-toggle="modal" data-bs-target="#modal-assigned">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                    @endif
                </div>
                <div>
                    @foreach ($ticket->assigneds as $assigned)
                        <x-user.avatar :user="$assigned" :tooltip="true" :detail="true" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('modals')
        @if($canAssignedUsers)
            <x-modal.modal :id="'modal-assigned'" :title="'Edit Assigned Users'">
                <x-slot name="body">
                    <form id="mainForm" method="POST" action="{{ route('assigneds.update', $ticket->code) }}">
                        @csrf
                        <div class="mb-3">
                            <select id="assigned_user" name="assigned_users[]" class="form-control" multiple style="width: 100%">
                                @foreach ($assignedUsers as $auser)
                                    <option value="{{ $auser->id }}"
                                        @selected(in_array($auser->id, $ticket->assigneds->pluck('id')->toArray()))>
                                        {{ $auser->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-invalid-feedback />
                        </div>
                        <div class="mt-3">
                            <button type="submit" id="mainFormBtn" class="btn btn-gray-800 mt-2 animate-up-2">Submit</button>
                        </div>
                    </form>
                </x-slot>
            </x-modal.modal>
        @endif

        <x-modal.modal :id="'modal-status-update'" :title="'Edit Status'" :modal_class="'modal-dialog-centered'">
            <x-slot name="body">
                <form id="mainFormStatus" method="POST" action="{{ route('tickets.status.update', $ticket->code) }}">
                    @csrf
                    <div class="text-center">
                        <h2 id="status-update-title" class="h5 modal-title my-2"></h2>
                        <input type="hidden" id="status" name="status" value="">
                        <x-invalid-feedback />
                        <div>
                            <button type="submit" id="mainFormBtnStatus" class="btn btn-gray-800 mt-2 animate-up-2">
                                Yes
                            </button>
                            <button type="button" class="btn btn-link text-gray-600 ms-auto" data-bs-dismiss="modal">
                                No
                            </button>
                        </div>
                    </div>
                </form>
            </x-slot>
        </x-modal.modal>
    @endpush

    @push('scripts')
        <script>mainFormSubmit();</script>
        <script>mainFormSubmit($("#mainFormStatus"), null, $("#mainFormBtnStatus"));</script>
        <script>
            $("#assigned_user").select2();
        </script>
        <script>
            var modalStatusUpdate = new bootstrap.Modal(document.getElementById('modal-status-update'));
            $(document).on('click', '.btn-status-update', function() {
                const status = this.value;
                let title = '';
                if (status == 'in_progress') {
                    title = 'Are you sure to PROCESS this ticket?';
                } else if (status == 'cancelled') {
                    title = 'Are you sure to CANCEL this ticket?';
                } else if (status == 'done') {
                    title = 'Are you sure to COMPLETE this ticket?';
                }

                if (title != '') {
                    $("#status-update-title").html(title);
                    $("#status").val(status);
                    modalStatusUpdate.show();
                }
            });
        </script>
    @endpush
</x-app-layout>