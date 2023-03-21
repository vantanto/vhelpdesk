@props(['title', 'description', 'action'])

<div class="d-flex align-items-ceter justify-content-between border-top pt-2 mb-2">
    <div>
        <h3 class="stitle h6 mb-1">{{ $title }}</h3>
        <p class="sdescription small m-0">
            {{ $description ?? '' }}
        </p>
    </div>
    <div>
        {{ $action ?? '' }}
    </div>
</div>