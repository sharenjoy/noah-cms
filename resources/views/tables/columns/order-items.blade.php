<div class="fi-ta-text grid w-full gap-y-1 px-1 py-1">
    <ul class="divide-y divide-gray-200">

        @foreach ($order->items as $item)
        @php
            $details = $item->product_details;
        @endphp
        <li class="flex items-center py-2">
          <img src="{{ \Sharenjoy\NoahCms\Utils\Media::imgUrl($details['product_image']) }}" class="w-16 h-16 object-cover rounded mr-4">
          <div class="flex-1 p-1">
            <h3 class="text-sm font-medium text-gray-700">{{ $details['product_name'] }}</h3>
          </div>
          <div class="flex-1 p-1">
            <h3 class="text-sm font-medium text-gray-700">{!! join(', ', $details['spec_detail_name']) !!}</h3>
          </div>
          <div class="w-12">
            <h3 class="text-sm font-medium text-gray-700">{{ $item->quantity }}</h3>
          </div>
        </li>
        @endforeach
      </ul>
</div>
