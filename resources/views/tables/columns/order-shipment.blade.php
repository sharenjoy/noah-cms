<div class="fi-ta-text grid w-full gap-y-1 px-3 py-4">
    <ul class="grid gap-1">
        <li><div class="font-bold text-sm" style="color: #3a3a3a">{{ $getState()->name }}</div></li>
        <li><div class="text-xs" style="color: #6e6e6e">{{ $getState()->calling_code }}{{ $getState()->mobile }}</div></li>
        <li class="flex justify-start gap-1 py-1">
            <div class="w-fit"><x-filament::badge size="sm" color="gray">{{ $getState()->provider->getLabel() }}</x-filament::badge></div>
            <div class="w-fit"><x-filament::badge size="sm" color="info">{{ $getState()->delivery_type->getLabel() }}</x-filament::badge></div>
        </li>
        <li><div class="text-xs" style="color: #6e6e6e">
        @if ($getState()->delivery_type == \Sharenjoy\NoahCms\Enums\DeliveryType::Address)
            @if ($getState()->country == 'Taiwan')
            {!! $getState()->city.$getState()->district.' '.$getState()->postcode.'<br>'.$getState()->address !!}
            @else
            {!! $getState()->address.'<br>'.$getState()->postcode.' '.$getState()->country !!}
            @endif
        @elseif ($getState()->delivery_type == \Sharenjoy\NoahCms\Enums\DeliveryType::Pickinstore)
            {!! $getState()->pickup_store_no.'<br>'.$getState()->pickup_store_name.'<br>'.$getState()->pickup_store_address !!}
        @elseif ($getState()->delivery_type == \Sharenjoy\NoahCms\Enums\DeliveryType::Pickinretail)
            {!! $getState()->pickup_retail_name !!}
        @endif
        </div></li>
        <li class="flex justify-start gap-1 pt-1">
            <div class="w-fit"><x-filament::badge size="sm" color="warning">{{ $getState()->status->getLabel() }}</x-filament::badge></div>
        </li>
    </ul>
</div>
