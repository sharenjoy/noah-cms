<?php

namespace Sharenjoy\NoahCms\Commands;

use Illuminate\Console\Command;
use Sharenjoy\NoahCms\Actions\Shop\ResolveGenerateUserCoupon;
use Sharenjoy\NoahCms\Enums\PromoType;
use Sharenjoy\NoahCms\Models\Promo;

class GenerateCouponPromos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'noah-cms:generate-coupon-promos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate coupon promos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $promos = Promo::with(['userObjectives.users', 'coupons'])->where('type', PromoType::Coupon)->get()->where('generatable', true);

        foreach ($promos as $promo) {
            dispatch(ResolveGenerateUserCoupon::makeJob($promo));
        }

        $this->info('Generate coupon promos successfully.');
    }
}
