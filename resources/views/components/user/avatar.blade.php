@props(['user', 'tooltip' => false, 'detail' => false])

<span @if($detail == true) data-bs-toggle="modal" data-bs-target="#modal-avatar" data-detail='@json(['id' => $user->id])' @endif>
    <img src="{{ $user->avatar_full_url }}" {{ $attributes->merge(['class' => 'avatar rounded-circle mb-1']) }} 
        @if($tooltip == true) data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user->name }}" @endif
    >
</span>

@if($detail == true)
    @once
        <x-modal.detail :id="'modal-avatar'"/>

        @push('scripts')
            <script>
                $(document).ready(function() {
                    getDataDetail('modal-avatar', "{{ route('users.detail') }}", function(result) {
                        if (result.status == 'success') {
                            const data = result.data;
                            $("#modal-avatar .modal-body").html(`
                                <div class="text-center">
                                    <img src="`+data.avatar_full_url+`" class="avatar-xl rounded-circle mt-n5 mb-4">
                                    <h4 class="h3">`+data.name+`</h4>
                                    <p class="text-gray">`+data.email+`</p>
                                </div>
                            `);
                        }
                    });
                });
            </script>
        @endpush
    @endonce
@endif