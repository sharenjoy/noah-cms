<?php

namespace Sharenjoy\NoahCms\Actions\Shop;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPromoAutoGenerateEvent
{
    use AsAction;

    public function handle(?string $key = null): array|string|null
    {
        $events = [];
        $sql = null;

        $conditions = setting('order.promo_conditions');

        foreach ($conditions as $condition) {
            if (!isset($condition['code']) || !isset($condition['name'])) {
                continue;
            }

            try {
                $decrypted = Crypt::decryptString($condition['code']);

                $check = explode("::", $decrypted);

                if (head($check) !== config('noah-cms.promo.conditions_decrypter') || end($check) !== config('noah-cms.promo.conditions_decrypter')) {
                    continue;
                }

                if (count($check) !== 4) {
                    continue;
                }

                if ($key && $key == $check[1]) {
                    $sql = $check[2];
                }

                $events[$check[1]] = $condition['name'];
            } catch (DecryptException $e) {
                // ...
            }
        }

        if ($key) {
            return $sql;
        }

        return $events;
    }
}
