<?php

namespace Sharenjoy\NoahCms\Resources\Traits;

use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ContentTabPosition;
use Illuminate\Database\Eloquent\SoftDeletes;

trait NoahEditRecord
{
    public function mountNoahEditRecord()
    {
        //
    }

    public function updatedNoahEditRecord()
    {
        //
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    public function getContentTabIcon(): ?string
    {
        return 'heroicon-o-pencil-square';
    }

    public function getContentTabLabel(): ?string
    {
        return __('noah-cms::noah-cms.edit_content');
    }

    protected function recordHeaderActions(): array
    {
        if (method_exists(static::getModel(), 'getReplicateAction')) {
            $actions[] = app(static::getModel())->getReplicateAction('record');
        }

        $actions[] = DeleteAction::make();

        if (in_array(SoftDeletes::class, class_uses(static::getModel()))) {
            $actions[] = RestoreAction::make();
            $actions[] = ForceDeleteAction::make();
        }

        return $actions;
    }
}
