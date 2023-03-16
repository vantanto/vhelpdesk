@props(['body' => null])
<x-modal.modal {{ $attributes }}/>

@once
    @push('scripts')
    <script>
        function getDataDetail(pId, pUrl, pSuccess) {
            $(document).on('click', `[data-bs-target="#${pId}"]`, function() {
                @if (!$body)
                    $(`#${pId} .modal-body`).html(`
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    `);
                @endif
                const data_detail = JSON.parse($(this).attr('data-detail'));
                $.ajax({
                    method: "get",
                    url: pUrl,
                    data: data_detail,
                    success: pSuccess,
                    error: function(result, textStatus, jqXHR) {
                        if (typeof result.responseJSON !== 'undefined' && typeof result.responseJSON.status !== 'undefined') {
                            swalAlert('error', result.responseJSON.msg);
                        } else {
                            swalAlert('error', 'Error!');
                        }
                    }
                });
            });
        }
    </script>
    @endpush
@endonce