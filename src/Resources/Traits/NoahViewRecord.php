<?php

namespace Sharenjoy\NoahCms\Resources\Traits;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Illuminate\Database\Eloquent\SoftDeletes;

trait NoahViewRecord
{
    public function mountNoahEditRecord()
    {
        //
    }

    public function updatedNoahEditRecord()
    {
        //
    }

    protected function recordHeaderActions(): array
    {
        $actions[] = EditAction::make();

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
