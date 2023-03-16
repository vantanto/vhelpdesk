@props(['id' => 'modal-detail', 'title' => 'Detail', 'body' => null, 'modal_class' => ''])

@push('modals')
<div id="{{ $id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}" aria-hidden="true">
    <div class="modal-dialog {{ $modal_class }}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="h6 modal-title">{!! $title !!}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $body }}
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@endpush