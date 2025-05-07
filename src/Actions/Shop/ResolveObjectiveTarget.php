<?php

namespace Sharenjoy\NoahCms\Actions\Shop;

use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Decorators\JobDecorator;
use Sharenjoy\NoahCms\Enums\ObjectiveStatus;
use Sharenjoy\NoahCms\Enums\ObjectiveType;
use Sharenjoy\NoahCms\Models\Objective;
use Sharenjoy\NoahCms\Models\Product;
use Sharenjoy\NoahCms\Models\User;
use Sharenjoy\NoahCms\Resources\Shop\ObjectiveResource;

class ResolveObjectiveTarget
{
    use AsAction;

    public function handle(Objective $objective): void
    {
        $objective->status = ObjectiveStatus::Processing;
        $objective->save();

        try {
            if ($objective->type === ObjectiveType::Product) {
                $this->resolveProduct($objective);
            } elseif ($objective->type === ObjectiveType::User) {
                $this->resolveUser($objective);
            }
        } catch (\Throwable $th) {
            // TODO: Log error
            $objective->status = ObjectiveStatus::Failed;
            $objective->save();

            Notification::make()
                ->danger()
                ->title('產生目標對象時發生錯誤')
                ->body($th->getMessage())
                ->actions([
                    Action::make('View')->url(ObjectiveResource::getUrl('edit', ['record' => $objective])),
                ])
                ->sendToDatabase(User::query()->superAdmin()->get());
        }

        $objective->status = ObjectiveStatus::Finished;
        $objective->generated_at = now();
        $objective->save();
    }

    protected function resolveProduct($objective)
    {
        $query = Product::query();
        $setting = $objective->product;

        $removeCategories = $setting['remove']['categories'] ?? [];
        $removeTags = $setting['remove']['tags'] ?? [];
        $removeProducts = $setting['remove']['products'] ?? [];

        if ($setting['all']) {
            $query->where(function ($q) use ($removeCategories, $removeTags, $removeProducts) {
                if (!empty($removeCategories)) {
                    $q->whereDoesntHave('categories', fn($q) => $q->whereIn('id', $removeCategories));
                }
                if (!empty($removeTags)) {
                    $q->whereDoesntHave('tags', fn($q) => $q->whereIn('id', $removeTags));
                }
                if (!empty($removeProducts)) {
                    $q->whereNotIn('id', $removeProducts);
                }
            });
        } else {
            $addCategories = array_diff($setting['add']['categories'] ?? [], $removeCategories);
            $addTags = array_diff($setting['add']['tags'] ?? [], $removeTags);
            $addProducts = array_diff($setting['add']['products'] ?? [], $removeProducts);

            $query->where(function ($q) use ($addCategories, $addTags, $addProducts) {
                if (!empty($addCategories)) {
                    $q->whereHas('categories', fn($q) => $q->whereIn('id', $addCategories));
                }
                if (!empty($addTags)) {
                    $q->orWhereHas('tags', fn($q) => $q->whereIn('id', $addTags));
                }
                if (!empty($addProducts)) {
                    $q->orWhereIn('id', $addProducts);
                }
            })->where(function ($q) use ($removeCategories, $removeTags, $removeProducts) {
                if (!empty($removeCategories)) {
                    $q->whereDoesntHave('categories', fn($q) => $q->whereIn('id', $removeCategories));
                }
                if (!empty($removeTags)) {
                    $q->whereDoesntHave('tags', fn($q) => $q->whereIn('id', $removeTags));
                }
                if (!empty($removeProducts)) {
                    $q->whereNotIn('id', $removeProducts);
                }
            });
        }

        // 寫入objectiveables
        $objective->products()->sync($query->get()->pluck('id'), detaching: true);
    }

    protected function resolveUser($objective)
    {
        $query = User::query();
        $setting = $objective->user;

        $removeTags = $setting['remove']['tags'] ?? [];
        $removeUsers = $setting['remove']['users'] ?? [];

        if ($setting['all']) {
            $query->where(function ($q) use ($removeTags, $removeUsers) {
                if (!empty($removeTags)) {
                    $q->whereDoesntHave('tags', fn($q) => $q->whereIn('id', $removeTags));
                }
                if (!empty($removeUsers)) {
                    $q->whereNotIn('id', $removeUsers);
                }
            });
        } else {
            $addTags = array_diff($setting['add']['tags'] ?? [], $removeTags);
            $addUsers = array_diff($setting['add']['users'] ?? [], $removeUsers);

            $query->where(function ($q) use ($addTags, $addUsers, $setting) {
                if (!empty($addTags)) {
                    $q->orWhereHas('tags', fn($q) => $q->whereIn('id', $addTags));
                }
                if (!empty($addUsers)) {
                    $q->orWhereIn('id', $addUsers);
                }

                // Age filtering
                foreach ($setting['parameter']['age'] ?? [] as $ageRange) {
                    if (empty($ageRange['age_start']) || empty($ageRange['age_end'])) {
                        continue;
                    }
                    $q->orWhere(function ($q) use ($ageRange) {
                        $q->where('age', '>=', $ageRange['age_start'])
                            ->where('age', '<=', $ageRange['age_end']);
                    });
                }

                // Location filtering
                foreach ($setting['parameter']['location'] ?? [] as $location) {
                    $q->orWhereHas('addresses', function ($q) use ($location) {
                        if (!empty($location['country'])) {
                            $q->where('country', $location['country']);
                        }
                        if (!empty($location['city'])) {
                            $q->where('city', $location['city']);
                        }
                        if (!empty($location['district'])) {
                            $q->where('district', $location['district']);
                        }
                    });
                }
            })->where(function ($q) use ($removeTags, $removeUsers) {
                if (!empty($removeTags)) {
                    $q->whereDoesntHave('tags', fn($q) => $q->whereIn('id', $removeTags));
                }
                if (!empty($removeUsers)) {
                    $q->whereNotIn('id', $removeUsers);
                }
            });
        }

        // 寫入objectiveables
        $objective->users()->sync($query->get()->pluck('id'), detaching: true);
    }

    public function asJob(Objective $objective): void
    {
        $this->handle($objective);
    }
}
