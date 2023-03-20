@props(['href' => null, 'download' => false, 'delete_name' => null, 'delete_value' => null])

<div class="input-group mb-3">
    <div class="form-control mb-0">
        <svg class="icon icon-xs text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 23 23" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" clip-rule="evenodd"></path>
        </svg>
        <a href="{{ $href }}" class="text-info" {{ $attributes }}>
            {{ basename($href) }}
        </a>
    </div>
    @if($download == true)
        <a href="{{ $href }}" download="{{ basename($href) }}" class="input-group-text">
            <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z"></path>
                <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z"></path>
            </svg>
        </a>
    @endif
    @if(!empty($delete_name) && !empty($delete_value))
        <button type="button" class="input-group-text btn btn-gray-200" onclick="fileDelete(this)">
            <svg class="icon icon-xs text-gray-600" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"></path>
            </svg>
        </button>
    @endif
</div>

@once
    @push('scripts')
        @if(!empty($delete_name) && !empty($delete_value)) 
            <script>
                function fileDelete(element) {
                    $(`<input type="hidden" name="{{ $delete_name }}" value="{{ $delete_value }}">`).insertAfter($(element).closest('.input-group'));
                    $(element).closest('.input-group').remove();
                }
            </script>
        @endif
    @endpush
@endonce