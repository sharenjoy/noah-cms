<?php

use Illuminate\Support\Facades\Route;
use Sharenjoy\NoahCms\Models\Promo;
use Sharenjoy\NoahCms\Models\UserCoupon;
use Sharenjoy\NoahCms\Notifications\UserCouponCreated;

// Route::prefix('noah-cms/notification')->group(function () {
//     Route::get('/user-coupon-created', function () {
//         $userCoupon = UserCoupon::find(1);
//         $promo = Promo::find(4);

//         return (new UserCouponCreated($userCoupon, $promo))
//             ->toMail($userCoupon->user);
//     });
// });
