<?php

namespace Sharenjoy\NoahCms\Models;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sharenjoy\NoahCms\Enums\ProductLimit;
use Sharenjoy\NoahCms\Enums\StockMethod;
use Sharenjoy\NoahCms\Models\Product;
use Sharenjoy\NoahCms\Models\Traits\CommonModelTrait;
use Sharenjoy\NoahCms\Models\Traits\HasMediaLibrary;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Translatable\HasTranslations;

class ProductSpecification extends Model implements Sortable
{
    use CommonModelTrait;
    use HasFactory;
    use LogsActivity;
    use SortableTrait;
    use HasTranslations;
    use HasMediaLibrary;

    protected $casts = [
        'spec_detail_name' => 'json',
        'album' => 'array',
        'stock_method' => 'json',
        'product_limit' => 'json',
        'is_active' => 'boolean',
    ];

    public $translatable = [
        'content',
    ];

    protected function formFields(): array
    {
        return [
            'left' => [
                'spec_detail_name' => Section::make()->schema([
                    KeyValue::make('spec_detail_name')
                        ->label(__('noah-cms::noah-cms.specification'))
                        ->keyLabel(__('noah-cms::noah-cms.spec_name'))
                        ->valueLabel(__('noah-cms::noah-cms.spec_detail_name'))
                        ->disabled(),
                ]),
                'no' => Section::make()->schema([
                    TextInput::make('no')->placeholder(__('noah-cms::noah-cms.spec_no'))->label(__('noah-cms::noah-cms.spec_no')),
                    TextInput::make('sku')->placeholder('SKU')->label('SKU'),
                    TextInput::make('code')->placeholder(__('noah-cms::noah-cms.spec_code'))->label(__('noah-cms::noah-cms.spec_code')),
                ])->columns(3),
                'price' => Section::make()->schema([
                    TextInput::make('price')->numeric()->placeholder(__('noah-cms::noah-cms.price'))->label(__('noah-cms::noah-cms.price'))->helperText('實際結帳價格'),
                    TextInput::make('compare_price')->numeric()->placeholder(__('noah-cms::noah-cms.compare_price'))->label(__('noah-cms::noah-cms.compare_price'))->helperText('通常可作為有刪除線的價格'),
                    TextInput::make('cost')->numeric()->placeholder(__('noah-cms::noah-cms.cost'))->label(__('noah-cms::noah-cms.cost')),
                ])->columns(3),
                'weight' => Section::make()->schema([
                    TextInput::make('weight')->numeric()->placeholder(1200)->label(__('noah-cms::noah-cms.weight'))->helperText('含包裝的重量，單位為公克(g)')
                ]),
                'check' => Section::make()->schema([
                    'delivery_limit' => CheckboxList::make('product_limit')
                        ->options(ProductLimit::class)
                        ->label(__('noah-cms::noah-cms.product_limit')),
                    'stock_method' => CheckboxList::make('stock_method')
                        ->options(StockMethod::class)
                        ->label(__('noah-cms::noah-cms.stock_method')),
                ])->columns(2),
                'content' => [
                    'profile' => 'simple',
                ],
            ],
            'right' => [
                'album' => ['required' => true],
                'is_active' => ['required' => true],
            ],
        ];
    }

    protected function tableFields(): array
    {
        return [
            'product.title' => ['label' => 'product_title'],
            'spec_detail_name' => [],
            'no' => ['label' => 'spec_no'],
            'price' => ['type' => 'number'],
            'compare_price' => ['type' => 'number'],
            'stock_method' => TextColumn::make('stock_method')->badge()->label(__('noah-cms::noah-cms.stock_method')),
            'is_active' => [],
            'created_at' => ['isToggledHiddenByDefault' => true],
            'updated_at' => ['isToggledHiddenByDefault' => true],
        ];
    }

    /** RELACTIONS */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /** SCOPES */

    /** EVENTS */

    /** OTHERS */
}
