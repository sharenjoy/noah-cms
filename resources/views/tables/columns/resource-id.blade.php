<div class="fi-ta-text grid w-full gap-y-1 px-3 py-4">
    @php
        $record = $getRecord();
        $content = $getContent();

        if (auth()->user()->can('view', $record)) {
            $url = $content['resource']::getUrl('view', ['record' => $record]);
        } else {
            $url = null;
        }
    @endphp
    <ul class="grid gap-1">
        @if ($url)
            <li><div class="font-bold text-sm align-middle" style="color: #3a3a3a"><a href="{{ $url }}"><span style="margin-left: 5px; margin-right: 2px;">#</span>{{ $getState() }}</a></div></li>
        @else
            <li><div class="font-bold text-sm align-middle" style="color: #3a3a3a"><span style="margin-left: 5px; margin-right: 2px;">#</span>{{ $getState() }}</div></li>
        @endif
    </ul>
</div>
