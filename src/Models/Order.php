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
use Sharenjoy\NoahCms\Enums\OrderStatus;
use Sharenjoy\NoahCms\Models\Invoice;
use Sharenjoy\NoahCms\Models\OrderItem;
use Sharenjoy\NoahCms\Models\OrderShipment;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    use CommonModelTrait;
    use HasFactory;
    use LogsActivity;

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    protected array $sort = [
        'created_at' => 'desc',
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
        return [
            'left' => [
                'title' => [
                    'slug' => true,
                    'required' => true,
                    'rules' => ['required', 'string'],
                ],
                'slug' => ['maxLength' => 50, 'required' => true],
                'categories' => ['required' => true],
                'tags' => ['min' => 2, 'max' => 5, 'multiple' => true],
                'description' => ['required' => true, 'rules' => ['required', 'string']],
                'content' => [
                    'profile' => 'simple',
                    'required' => true,
                    'rules' => ['required'],
                ],
            ],
            'right' => [
                'img' => ['required' => true],
                'album' => ['required' => true],
                'is_active' => ['required' => true],
                'published_at' => ['required' => true],
            ],
        ];
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
                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                ->size(\Filament\Tables\Columns\IconColumn\IconColumnSize::Medium),
            'sn' => ['label' => 'order_sn'],
            'status' => ['label' => 'order_status', 'model' => 'order'],
            'order_items' => \Filament\Tables\Columns\TextColumn::make('items_count')
                ->counts('items')
                ->badge()
                ->color('success')
                ->label(__('noah-cms::noah-cms.order_item_counts'))
                ->tooltip('點擊可快速查看品項')
                ->action(
                    Action::make('view_items')
                        ->label(__('noah-cms::noah-cms.order_item_counts'))
                        ->modal()
                        ->modalCancelAction(false)
                        ->modalSubmitAction(false)
                        ->modalWidth(\Filament\Support\Enums\MaxWidth::Large)
                        ->modalContent(fn(Order $order) => view('noah-cms::tables.columns.order-items', ['order' => $order]))
                ),
            'order_user' => [],
            'order_shipment' => [],
            'order_transaction' => [],
            'order_invoice' => [],
            'created_at' => ['isToggledHiddenByDefault' => true],
            'updated_at' => ['isToggledHiddenByDefault' => true],
        ];
    }

    /** RELACTIONS */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shipments(): HasMany
    {
        return $this->hasMany(OrderShipment::class)->orderBy('created_at', 'desc');
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(OrderShipment::class)->orderBy('created_at', 'desc');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class)->orderBy('created_at', 'desc');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class)->orderBy('created_at', 'desc');
    }

    /** SCOPES */

    public function scopeValidOrders($query): Builder
    {
        return $query->whereNotIn('status', [OrderStatus::Initial, OrderStatus::Cancelled]);
    }

    /** EVENTS */

    /** OTHERS */

    protected static function newFactory()
    {
        return \Sharenjoy\NoahCms\Database\Factories\OrderFactory::new();
    }
}
