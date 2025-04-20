<?php

namespace Sharenjoy\NoahCms\Utils\Tables;

use Filament\Tables\Columns\ImageColumn;
use Sharenjoy\NoahCms\Utils\Media;
use Sharenjoy\NoahCms\Utils\Tables\TableAbstract;
use Sharenjoy\NoahCms\Utils\Tables\TableInterface;

class Image extends TableAbstract implements TableInterface
{
    public function make()
    {
        return ImageColumn::make('img')
            ->label(__('noah-cms::noah-cms.image'))
            ->circular()
            ->size($content['size'] ?? 40)
            ->alignCenter()
            ->defaultImageUrl(function ($record) {
                return Media::imgUrl($record->product_details['img']) ?? asset('vendor/noah-cms/images/placeholder.svg');
            })
            ->toggleable(isToggledHiddenByDefault: $content['isToggledHiddenByDefault'] ?? false);
    }
}
