<div class="fi-ta-text grid w-full gap-y-1 px-3 py-4">
    @php
        $state = $getState();
    @endphp

    <div class="flex gap-1 items-center">
        <x-filament::badge size="lg" color="info">{{ $state->getLabel() }}</x-filament::badge>
        @if($state->value == 'processing')
        <x-filament::loading-indicator class="h-5 w-5" />
        @endif
    </div>
</div>
