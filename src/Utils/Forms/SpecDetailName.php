<?php

namespace Sharenjoy\NoahCms\Utils\Forms;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Get;
use Illuminate\Support\Arr;

class SpecDetailName extends FormAbstract implements FormInterface
{
    public function make()
    {
        if ($this->ownerRecord) {
            if ($this->ownerRecord->is_single_spec === false) {
                $this->field = KeyValue::make('spec_detail_name')
                    ->label(__('noah-cms::noah-cms.specification'))
                    ->keyLabel(__('noah-cms::noah-cms.spec_name'))
                    ->valueLabel(__('noah-cms::noah-cms.spec_detail_name'))
                    ->addable(false)
                    ->deletable(false)
                    ->editableKeys(false)
                    ->rules([
                        fn(): \Closure => function (string $attribute, $value, \Closure $fail) {
                            $values = array_values($value);
                            foreach ($values as $value) {
                                if (! $value)
                                    $fail(__('validation.required'));
                            }
                        },
                    ])
                    ->default(function (Get $get) {
                        return array_fill_keys(Arr::pluck($this->ownerRecord->specs, 'spec_name'), '');
                    });
            } else {
                $this->field = Placeholder::make(__('noah-cms::noah-cms.single_spec'));
            }
        } else {
            $this->field = Grid::make()->schema([
                Placeholder::make(__('noah-cms::noah-cms.single_spec'))
                    ->visible(fn(Get $get): bool => $get('spec_detail_name') == 'single_spec'),
                KeyValue::make('spec_detail_name')
                    ->label(__('noah-cms::noah-cms.specification'))
                    ->keyLabel(__('noah-cms::noah-cms.spec_name'))
                    ->valueLabel(__('noah-cms::noah-cms.spec_detail_name'))
                    ->addable(false)
                    ->deletable(false)
                    ->editableKeys(false)
                    ->rules([
                        fn(): \Closure => function (string $attribute, $value, \Closure $fail) {
                            $values = array_values($value);
                            foreach ($values as $value) {
                                if (! $value)
                                    $fail(__('validation.required'));
                            }
                        },
                    ])
                    ->visible(fn(Get $get): bool => $get('spec_detail_name') != 'single_spec')
                    ->columnSpanFull(),
            ]);
        }

        // dd($specs, $this->model);

        return $this->field;
    }
}
