<?php

namespace Sharenjoy\NoahCms\Exceptions;

use Exception;

class UserNotAllowPromoCouponAssigned extends Exception
{
    public function __construct($message = null)
    {
        $message = $message ?? __('noah-cms::noah-cms.shop.promo.title.notallowed_generatable');
        parent::__construct($message);
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], 403);
    }
}
