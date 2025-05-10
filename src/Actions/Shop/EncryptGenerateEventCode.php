<?php

namespace Sharenjoy\NoahCms\Actions\Shop;

use Illuminate\Support\Facades\Crypt;
use Lorisleiva\Actions\Concerns\AsAction;

class EncryptGenerateEventCode
{
    use AsAction;

    public function handle($code, $slug): string
    {
        $divider = config('noah-cms.promo.conditions_divider');
        $decrypter = config('noah-cms.promo.conditions_decrypter');

        $encrypted = Crypt::encryptString(
            $decrypter . $divider . $slug . $divider . $code . $divider . $decrypter
        );

        return $encrypted;
    }
}
