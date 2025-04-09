<?php

namespace Sharenjoy\NoahCms\Utils;

use Exception;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RalphJSmit\Filament\Activitylog\Forms\Components\Timeline;
use RalphJSmit\Filament\MediaLibrary\Forms\Components\MediaPicker;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Spatie\Activitylog\Traits\LogsActivity;

class Form
{
    protected static $model;
    protected static $operation;
    protected static $ownerRecord;
    protected static $translatable;

    public static function make(string $model, string $operation, $ownerRecord = null): array
    {
        $modelInstance = app($model);

        static::$model = $model;
        static::$operation = $operation;
        static::$ownerRecord = $ownerRecord;
        static::$translatable = $modelInstance->translatable;

        $form = $modelInstance->getFormFields();
        $schemas = [];

        $schemas = static::organizeLeftGrid($schemas, $form);
        $schemas = static::organizeRightGrid($schemas, $form);

        $tabs = [];

        if (in_array(HasSEO::class, class_uses(static::$model)) && config('noah-cms.featureToggle.seo')) {
            $tabs[] = Tabs\Tab::make('SEO')
                ->schema([
                    static::setSeoField()
                ]);
        }

        if (in_array(LogsActivity::class, class_uses(static::$model)) && config('noah-cms.featureToggle.logActivity')) {
            $tabs[] = Tabs\Tab::make(__('noah-cms::noah-cms.activity_log'))
                ->schema([
                    static::setActivityLogField()
                ]);
        }

        if (count($tabs)) {
            array_unshift($tabs, Tabs\Tab::make(__('noah-cms::noah-cms.content'))
                ->columns(3)
                ->schema($schemas));

            $schemas = [
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->contained(false)
                    ->persistTabInQueryString()
                    ->tabs($tabs),
            ];
        }

        return $schemas;
    }

    protected static function organizeLeftGrid($schemas, $form)
    {
        $span = array_key_exists('right', $form) === false || count($form['right']) === 0
            ? ['lg' => fn($record) => $record === null ? 3 : 2]
            : ['lg' => 2];

        $schemas[] = Grid::make()->columnSpan($span)->schema(static::organizeForm($form['left'], 'left'));

        return $schemas;
    }

    protected static function organizeRightGrid($schemas, $form)
    {
        $schemas[] = Grid::make()->columnSpan(['lg' => 1])->schema(static::organizeForm($form['right'], 'right'));

        return $schemas;
    }

    protected static function organizeForm($items, $position)
    {
        $fields = [];

        foreach ($items as $name => $content) {
            if (! is_array($content)) {
                // 可以直接使用 Filamane form field component
                $fields[] = $content;
            } else {
                $method = str()->camel($name);
                $class = str()->studly((isset($content['alias']) ? $content['alias'] : $name));

                if (class_exists('\\App\\Filament\\Utils\\Forms\\' . $class)) {
                    // custom class
                    $obj = new ("\\App\\Filament\\Utils\\Forms\\$class")(fieldName: $name, content: $content, translatable: static::$translatable, model: static::$model, ownerRecord: static::$ownerRecord);
                    $schema = $obj->make();
                } elseif (class_exists('\\Sharenjoy\\NoahCms\\Utils\\Forms\\' . $class)) {
                    // class
                    $obj = new ("\\Sharenjoy\\NoahCms\\Utils\\Forms\\$class")(fieldName: $name, content: $content, translatable: static::$translatable, model: static::$model, ownerRecord: static::$ownerRecord);
                    $schema = $obj->make();
                } else {
                    throw new Exception('No class available that matches. -> ' . $class);
                    // method
                    // $schema = static::$method(fieldName: $name, content: $content);
                }

                if (in_array($name, static::$translatable)) {
                    $fields[] = Grid::make()->schema([$schema]);
                } else {
                    $fields[] = Section::make()->schema([$schema]);
                }
            }
        }

        $fields = static::extendSection($fields, $position);

        return $fields;
    }

    protected static function extendSection($fields, $position)
    {
        if ($position == 'left') {
            //
        }

        if ($position == 'right') {
            $fields[] = Section::make(__('noah-cms::noah-cms.time'))
                ->hidden(fn($record) => $record === null)
                ->schema([
                    Placeholder::make('created_at')
                        ->label(__('noah-cms::noah-cms.created_at'))
                        ->content(fn($record): ?string => $record->created_at?->diffForHumans()),
                    Placeholder::make('updated_at')
                        ->label(__('noah-cms::noah-cms.last_modified_at'))
                        ->content(fn($record): ?string => $record->updated_at?->diffForHumans()),
                ]);
        }

        return $fields;
    }

    protected static function setSeoField()
    {
        return Group::make([
            TextInput::make('title')
                ->label(__('noah-cms::noah-cms.title') . ' (Meta)')
                ->helperText(function (?string $state): string {
                    return (string) Str::of(strlen($state))
                        ->append(' / ')
                        ->append(120 . ' ')
                        ->append(__('noah-cms::noah-cms.characters'));
                })
                ->translatable()
                ->reactive()
                ->columnSpan(2),
            TextInput::make('author')
                ->label(__('noah-cms::noah-cms.author') . ' (Meta)')
                ->translatable()
                ->columnSpan(2),
            Textarea::make('description')
                ->label(__('noah-cms::noah-cms.description') . ' (Meta)')
                ->helperText(function (?string $state): string {
                    return (string) Str::of(strlen($state))
                        ->append(' / ')
                        ->append(240 . ' ')
                        ->append(__('noah-cms::noah-cms.characters'));
                })
                ->translatable()
                ->reactive()
                ->columnSpan(2),
            Section::make()
                ->columnSpan(2)
                ->schema([
                    MediaPicker::make('image')->label(__('noah-cms::noah-cms.choose_image') . ' (Meta)')->showFileName(),
                    Select::make('robots')
                        ->label(__('noah-cms::noah-cms.robots'))
                        ->columnSpan(2)
                        ->default('index, follow')
                        ->options([
                            'index, follow' => 'Index, Follow',
                            'index, nofollow' => 'Index, Nofollow',
                            'noindex, follow' => 'Noindex, Follow',
                            'noindex, nofollow' => 'Noindex, Nofollow',
                        ]),
                ]),

        ])->relationship('seo')
            ->statePath('seo')
            ->dehydrated(false)
            ->saveRelationshipsUsing(function (Model $record, array $state): void {
                $state = collect($state)->map(fn($value) => $value ?: null)->all();
                if ($record->seo && $record->seo->exists) {
                    $record->seo->update($state);
                } else {
                    $record->seo()->create($state);
                }
            });
    }

    protected static function setActivityLogField()
    {
        return Section::make([
            Timeline::make()
                ->label(__('noah-cms::noah-cms.activity_log'))
        ]);
    }
}
