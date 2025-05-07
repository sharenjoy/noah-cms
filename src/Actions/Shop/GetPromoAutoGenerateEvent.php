<?php

namespace Sharenjoy\NoahCms\Actions\Shop;

use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Lorisleiva\Actions\Concerns\AsAction;
use Sharenjoy\NoahCms\Models\User;
use Sharenjoy\NoahCms\Pages\Settings\Settings;

class GetPromoAutoGenerateEvent
{
    use AsAction;

    public function handle(?string $key = null): array|string|null
    {
        $events = [];
        $code = null;

        $conditions = setting('order.promo_conditions');

        foreach ($conditions as $condition) {
            if (!isset($condition['code']) || !isset($condition['name'])) {
                continue;
            }

            try {
                $decrypted = Crypt::decryptString($condition['code']);

                $check = explode(":::", $decrypted);

                if (head($check) !== config('noah-cms.promo.conditions_decrypter') || end($check) !== config('noah-cms.promo.conditions_decrypter')) {
                    continue;
                }

                if (count($check) !== 4) {
                    continue;
                }

                if ($key && $key == $check[1]) {
                    $code = $check[2];
                }

                $events[$check[1]] = $condition['name'];
            } catch (DecryptException $e) {
                Notification::make()
                    ->danger()
                    ->title('折扣碼條件設定解碼錯誤')
                    ->body($e->getMessage())
                    ->actions([
                        Action::make('View')->url(Settings::getUrl(['tab' => '-promo-tab'])),
                    ])
                    ->sendToDatabase(User::query()->superAdmin()->get());
            }
        }

        if ($key) {
            return $code;
        }

        return $events;
    }
}
