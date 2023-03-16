@props(['value'])

<span {{ $attributes->class([
    'badge' => true,
    'bg-warning text-primary' => $value == 'waiting',
    'bg-purple' => $value == 'in_progress',
    'bg-success' => $value == 'done',
    'bg-danger' => $value == 'cancelled',
]) }}>
    {{ ucwords(str_replace('_', ' ', $value)) }}
</span>

@once
    @push('scripts')
        <script>
            function ticketStatus(value) {
                return `<span class="badge `
                    + (value == 'waiting' ? 'bg-warning text-primary' 
                        : (value == 'in_progress' ? 'bg-purple'
                            : (value == 'done' ? 'bg-success'
                                : (value == 'cancelled' ? 'bg-danger'
                                    : ''
                                )
                            )
                        )
                    )
                    +`">` + ucwords(value.replace('_', ' ')) + `</span>`;
            }
        </script>
    @endpush
@endonce
