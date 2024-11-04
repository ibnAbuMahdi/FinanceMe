@props(['label', 'name'])
<div>
    @if ($label)
        <x-forms.label :$name :$label></x-forms>
    @endif
        <div class="mt-1">
            {{ $slot }}

            <x-forms.error :error="$errors->first($name)"/>
        </div>
</div>