<?php

namespace Sharenjoy\NoahCms\Loggers;

use Sharenjoy\NoahCms\Models\Tag;
use Sharenjoy\NoahCms\Resources\TagResource;
use Illuminate\Contracts\Support\Htmlable;
use Noxo\FilamentActivityLog\Loggers\Logger;
use Noxo\FilamentActivityLog\ResourceLogger\Field;
use Noxo\FilamentActivityLog\ResourceLogger\RelationManager;
use Noxo\FilamentActivityLog\ResourceLogger\ResourceLogger;

class TagLogger extends Logger
{
    public static ?string $model = Tag::class;

    public static function getLabel(): string | Htmlable | null
    {
        return TagResource::getModelLabel();
    }

    public static function resource(ResourceLogger $logger): ResourceLogger
    {
        return $logger
            ->fields([
                Field::make('name')
                    ->label(__('Title')),

                Field::make('type')
                    ->label(__('Type')),
            ])
            ->relationManagers([
                //
            ]);
    }
}
