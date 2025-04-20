<?php

namespace Sharenjoy\NoahCms\Models;

use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahCms\Actions\GenerateSeriesNumber;
use Sharenjoy\NoahCms\Enums\DeliveryProvider;
use Sharenjoy\NoahCms\Enums\DeliveryType;
use Sharenjoy\NoahCms\Enums\OrderShipmentStatus;
use Sharenjoy\NoahCms\Models\Order;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
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
            'title' => ['description' => true],
            'slug' => [],
            'categories' => [],
            'tags' => ['tagType' => 'product'],
            'thumbnail' => [],
            'seo' => [],
            'is_active' => [],
            'published_at' => [],
            'created_at' => ['isToggledHiddenByDefault' => true],
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
}
