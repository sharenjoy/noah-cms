<div class="fi-ta-text grid w-full gap-y-1 px-3 py-4">
    <ul class="grid gap-1">
        <li>
            <div class="font-bold text-sm" style="color: #3a3a3a">
                @if ($getState()->currency == 'TWD')
                {{ $getState()->currency }} {{ number_format($getState()->total_price) }}
                @else
                {{ $getState()->currency }} {{ number_format($getState()->total_price, 2) }}
                @endif
            </div>
        </li>
        <li class="flex justify-start gap-1 py-1">
            <div class="w-fit"><x-filament::badge size="sm" color="gray">{{ $getState()->provider->getLabel() }}</x-filament::badge></div>
            <div class="w-fit"><x-filament::badge size="sm" color="info">{{ $getState()->payment_method->getLabel() }}</x-filament::badge></div>
        </li>
        @if ($getState()->payment_method == \Sharenjoy\NoahCms\Enums\PaymentMethod::ATM)
        <li><div class="text-xs" style="color: #6e6e6e">
            {!! 'ATM '.$getState()->atm_code.'<br>到期 '.$getState()->expired_at !!}
        </div></li>
        @endif
        <li class="flex justify-start gap-1 pt-1">
            <div class="w-fit"><x-filament::badge size="sm" color="danger">{{ $getState()->status->getLabel() }}</x-filament::badge></div>
        </li>
    </ul>
</div>
