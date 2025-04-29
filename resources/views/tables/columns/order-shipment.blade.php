<div class="fi-ta-text grid w-full gap-y-1 px-3 py-4">
    @if ($getState())
        @php
            $shipment = $getState();
        @endphp
        <ul class="grid gap-1">
            <li><div class="font-bold text-sm" style="color: #3a3a3a">{{ $shipment->name }}</div></li>
            <li><div class="text-xs" style="color: #555">{{ $shipment->calling_code }} {{ $shipment->mobile }}</div></li>
            <li class="flex justify-start gap-1 py-1">
                <div class="w-fit">
                    <div class="flex gap-1">
                        <x-filament::avatar
                            src="{{ asset('vendor/noah-cms/images/'.$shipment->provider->value.'.png') }}"
                            size="sm"
                        />
                        <x-filament::badge size="sm" color="gray">{{ $shipment->provider->getLabel() }}</x-filament::badge>
                        <x-filament::badge size="sm" color="info">{{ $shipment->delivery_type->getLabel() }}</x-filament::badge>
                    </div>
                </div>
            </li>
            <li><div class="text-xs" style="color: #555">{!! \Sharenjoy\NoahCms\Actions\Shop\DisplayOrderShipmentDetail::run(shipment: $shipment) !!}</div></li>
            <li class="flex justify-start gap-1 pt-1">
                <div class="w-fit"><x-filament::badge size="sm" color="warning">{{ $shipment->status->getLabel() }}</x-filament::badge></div>
            </li>
        </ul>
    @else
        @php
            $shipment = $getRecord();
        @endphp
        <ul class="grid gap-1">
            <li><div class="font-bold text-md" style="color: #3a3a3a">{{ $shipment->name }}</div></li>
            <li><div class="text-sm" style="color: #555">{{ $shipment->calling_code }} {{ $shipment->mobile }}</div></li>
            <li><div class="text-sm" style="color: #555">{!! \Sharenjoy\NoahCms\Actions\Shop\DisplayOrderShipmentDetail::run(shipment: $shipment) !!}</div></li>
        </ul>
    @endif

</div>
