<?php

namespace Sharenjoy\NoahCms\Models;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahCms\Actions\Shop\DisplayOrderItemPrice;
use Sharenjoy\NoahCms\Models\Product;
use Sharenjoy\NoahCms\Models\ProductSpecification;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class OrderItem extends Model
{
    use CommonModelTrait;
    use LogsActivity;

    protected $casts = [
        'preorder' => 'boolean',
        'quantity' => 'integer',
        'product_details' => 'json',
    ];

    protected array $sort = [
        'created_at' => 'asc',
    ];

    protected function formFields(): array
    {
        return [];
    }

    protected function tableFields(): array
    {
        return [
            'product.title' => ['alias' => 'belongs_to', 'label' => 'product_title', 'relation' => 'product'],
            'productSpecification.spec_detail_name' => ['alias' => 'belongs_to', 'label' => 'spec_detail_name', 'relation' => 'productSpecification'],
            'spec_img' => ['alias' => 'image'],
            'price' => ['type' => 'number', 'summarize' => ['sum']],
            'discount' => ['type' => 'number', 'summarize' => ['sum']],
            'currency' => [],
            'quantity' => ['type' => 'number'],
            'order_item_subtotal' => TextColumn::make('id')
                ->label(__('noah-cms::noah-cms.subtotal'))
                ->sortable()
                ->formatStateUsing(function ($state, $record) {
                    return DisplayOrderItemPrice::run($record);
                }),
            'created_at' => ['isToggledHiddenByDefault' => true],
            'updated_at' => ['isToggledHiddenByDefault' => true],
        ];
    }

    /** RELACTIONS */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function productSpecification(): BelongsTo
    {
        return $this->belongsTo(ProductSpecification::class);
    }

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(OrderShipment::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */
}
