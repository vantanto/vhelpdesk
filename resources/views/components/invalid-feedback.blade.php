@props(['value'])

<div {{ $attributes->merge(['class' => 'invalid-feedback']) }}>
    {{ $value ?? $slot }}
</div>
