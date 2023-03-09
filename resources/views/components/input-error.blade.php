@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-danger my-2']) }}>
        @foreach ((array) $messages as $message)
            <li><small>{{ $message }}</small></li>
        @endforeach
    </ul>
@endif
