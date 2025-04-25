<?php

namespace Sharenjoy\NoahCms\Models;

use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Sharenjoy\NoahCms\Actions\GenerateSeriesNumber;
use Sharenjoy\NoahCms\Enums\OrderShipmentStatus;
use Sharenjoy\NoahCms\Enums\OrderStatus;
use Sharenjoy\NoahCms\Enums\TransactionStatus;
use Sharenjoy\NoahCms\Models\Invoice;
use Sharenjoy\NoahCms\Models\InvoicePrice;
use Sharenjoy\NoahCms\Models\Order;
use Sharenjoy\NoahCms\Models\OrderItem;
use Sharenjoy\NoahCms\Models\OrderShipment;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Sharenjoy\NoahCms\Models\Transaction;
use Sharenjoy\NoahCms\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;

class BaseOrder extends Model
{
    use CommonModelTrait;
    use HasFactory;
    use LogsActivity;

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    protected array $sort = [
        'created_at' => 'desc',
        'id' => 'desc',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->sn) {
                $model->sn = GenerateSeriesNumber::run('order');
            }
        });
    }

    protected function formFields(): array
    {
        return [];
    }

    protected function tableFields(): array
    {
        return [
            'notes' => \Filament\Tables\Columns\IconColumn::make('notes')
                ->label(__('noah-cms::noah-cms.order_notes'))
                ->tooltip(fn($state) => $state)
                ->width('1%')
                ->alignCenter()
                ->placeholder('-')
                ->sortable()
                ->icon('heroicon-o-document-text')
                ->size(\Filament\Tables\Columns\IconColumn\IconColumnSize::Medium),
            'sn' => ['alias' => 'order_sn', 'label' => 'order_sn'],
            'status' => ['label' => 'order_status', 'model' => 'order'],
            'order_items' => \Filament\Tables\Columns\TextColumn::make('items_count')
                ->counts('items')
                ->badge()
                ->color('gray')
                ->label(__('noah-cms::noah-cms.order_item_counts'))
                ->tooltip('點擊可快速查看品項')
                ->sortable()
                ->action($this->viewOrderItemsAction()),
            'order_user' => [],
            'order_shipment' => [],
            'order_transaction' => [],
            'order_invoice' => [],
            'dates' => [],
        ];
    }

    /** RELACTIONS */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(OrderShipment::class, 'order_id')->orderBy('created_at', 'desc');
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(OrderShipment::class, 'order_id')->orderBy('created_at', 'desc');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'order_id');
    }

    public function invoicePrices(): HasMany
    {
        return $this->hasMany(InvoicePrice::class, 'order_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'order_id')->orderBy('created_at', 'desc');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'order_id')->orderBy('created_at', 'desc');
    }

    /** SCOPES */

    public function scopeValidOrders($query): Builder
    {
        return $query->whereNotIn('status', [OrderStatus::Initial, OrderStatus::Cancelled]);
    }

    public function scopeAllEstablished($query): Builder
    {
        return $query->whereNotIn('status', [
            OrderStatus::Initial,
        ]);
    }

    public function scopeNew($query): Builder
    {
        return $query->whereIn('status', [
            OrderStatus::New,
        ]);
    }

    public function scopeShippable($query): Builder
    {
        return $query->whereIn('status', [
            OrderStatus::Processing,
        ])->whereHas('shipment', function ($query) {
            $query->whereIn('status', [OrderShipmentStatus::New]);
        })->whereHas('transaction', function ($query) {
            $query->where('status', TransactionStatus::Paid)->orWhere('total_price', 0);
        });
    }

    public function scopeShipped($query): Builder
    {
        return $query->whereIn('status', [
            OrderStatus::Processing,
        ])->whereHas('shipment', function ($query) {
            $query->whereIn('status', [OrderShipmentStatus::Shipped]);
        });
    }

    public function scopeDelivered($query): Builder
    {
        return $query->whereIn('status', [
            OrderStatus::Processing,
        ])->whereHas('shipment', function ($query) {
            $query->whereIn('status', [OrderShipmentStatus::Delivered]);
        });
    }

    public function scopeShouldProcessQuery($query)
    {
        $query->where(function ($query) {
            $query->whereIn('status', ['paid'])
                ->orWhere(function ($query) {
                    $query->whereIn('status', ['established'])->whereIn('payment_method', ['cod']);
                })
                ->orWhere(function ($query) {
                    $query->whereIn('status', ['established'])->whereRelation('invoice', 'total_amount', 0);
                })
                ->orWhere(function ($query) {
                    $query->whereIn('status', ['established'])->whereRelation('batch.invoice', 'total_amount', 0);
                });
        });
    }

    /** EVENTS */

    /** OTHERS */

    protected static function newFactory()
    {
        return \Sharenjoy\NoahCms\Database\Factories\OrderFactory::new();
    }
}
