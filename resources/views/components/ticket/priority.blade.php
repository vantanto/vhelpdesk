@props(['value'])

<span {{ $attributes->class([
    'text-success' => $value == 'low',
    'text-warning' => $value == 'medium',
    'text-danger' => $value == 'high',
]) }}>
    <strong>{{ ucwords($value) }}</strong>
</span>

@once
    @push('scripts')
        <script>
            function ticketPriority(value) {
                return `<span class="`
                    + (value == 'low' ? 'text-success' 
                        : (value == 'medium' ? 'text-warning'
                            : (value == 'high' ? 'text-danger'
                                : ''
                            )
                        )
                    )
                    +`"><strong>` + ucwords(value) + `</strong></span>`;
            }
        </script>
    @endpush
@endonce
