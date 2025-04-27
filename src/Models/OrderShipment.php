<?php

namespace Sharenjoy\NoahCms\Models;

use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahCms\Actions\GenerateSeriesNumber;
use Sharenjoy\NoahCms\Enums\DeliveryProvider;
use Sharenjoy\NoahCms\Enums\DeliveryType;
use Sharenjoy\NoahCms\Enums\OrderShipmentStatus;
use Sharenjoy\NoahCms\Models\Order;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Sharenjoy\NoahCms\Tables\Columns\OrderShipmentColumn;
use Spatie\Activitylog\Traits\LogsActivity;

class OrderShipment extends Model
{
    use CommonModelTrait;
    use LogsActivity;

    protected $casts = [
        'status' => OrderShipmentStatus::class,
        'provider' => DeliveryProvider::class,
        'delivery_type' => DeliveryType::class,
    ];

    protected $appends = [
        'delivery_method',
        'call',
    ];

    protected array $sort = [
        'created_at' => 'desc',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->sn) {
                $model->sn = GenerateSeriesNumber::run(model: 'shipment', prefix: 'S', strLeng: 4);
            }
        });
    }

    protected function formFields(): array
    {
        return [
            'left' => [
                'provider' => Select::make('provider')
                    ->label(__('noah-cms::noah-cms.delivery_provider'))
                    ->options(DeliveryProvider::class),
            ],
            'right' => [],
        ];
    }

    protected function tableFields(): array
    {
        return [
            // 'promo.title' => ['alias' => 'belongs_to', 'label' => 'promo', 'relation' => 'promo'],
            // 'user.name' => ['alias' => 'belongs_to', 'label' => 'administrator', 'relation' => 'user', 'relation_column' => 'admin_id'],
            'provider' => TextColumn::make('provider')
                ->label(__('noah-cms::noah-cms.activity.label.provider'))
                ->sortable()
                ->searchable()
                ->badge(DeliveryProvider::class),
            'delivery_type' => TextColumn::make('delivery_type')
                ->label(__('noah-cms::noah-cms.activity.label.delivery_type'))
                ->sortable()
                ->searchable()
                ->badge(DeliveryType::class),
            'status' => TextColumn::make('status')
                ->label(__('noah-cms::noah-cms.order_shipment_status'))
                ->sortable()
                ->searchable()
                ->badge(OrderShipmentStatus::class),
            'shipment' => OrderShipmentColumn::make('')
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query->whereHas('shipment', function ($query) use ($search) {
                        $query->where('sn', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%")
                            ->orWhere('country', 'like', "%{$search}%")
                            ->orWhere('city', 'like', "%{$search}%")
                            ->orWhere('district', 'like', "%{$search}%")
                            ->orWhere('address', 'like', "%{$search}%")
                            ->orWhere('postoffice_delivery_code', 'like', "%{$search}%");
                    });
                })
                ->label(__('noah-cms::noah-cms.' . ($this->content['label'] ?? $this->fieldName))),
            'created_at' => ['isToggledHiddenByDefault' => false],
            'updated_at' => ['isToggledHiddenByDefault' => true],
        ];
    }

    /** RELACTIONS */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */

    protected function deliveryMethod(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => DeliveryProvider::getLabelOptions($attributes['provider']) . ' ' . DeliveryType::getLabelOptions($attributes['delivery_type']),
        );
    }

    protected function call(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => '+' . $attributes['calling_code'] . ' ' . $attributes['mobile']
        );
    }
}
