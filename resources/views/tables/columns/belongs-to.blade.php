<div class="fi-ta-text grid w-full gap-y-1 px-3 py-4">
    @php
        $content = $getContent();
        $state = $getState();
        if (is_array($state)) {
            $state = implode(', ', $state);
        }
    @endphp

    @if($getRecord()->{$content['relation_column']})
    <a href="{{ route('filament.' . \Filament\Facades\Filament::getCurrentPanel()->getId() . '.resources.' . $content['relation_route'] . '.'.($content['operation'] ?? 'edit'), [
            'record' => $getRecord()->{$content['relation_column']},
    ]) }}"><span class="link-text">{!! $state !!}</span></a>
    @else
    <span class="text-center text-gray-400">-</span>
    @endif
</div>

<style>
    .link-text {
        color: rgb(var(--primary-600));
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
    }
    .link-text:hover {
        transition: color 0.3s ease, text-decoration 0.3s ease;
        color: rgb(var(--primary-900));
        text-decoration: under;
    }
</style>
