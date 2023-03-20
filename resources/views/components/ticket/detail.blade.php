@props(['body' => null])
<x-modal.detail {{ $attributes }} />

@once
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
@endonce