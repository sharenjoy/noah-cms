<?php

namespace Sharenjoy\NoahCms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Sharenjoy\NoahCms\Actions\Shop\CalculatePricesAndUpdateInvoice;
use Sharenjoy\NoahCms\Enums\DeliveryProvider;
use Sharenjoy\NoahCms\Enums\DeliveryType;
use Sharenjoy\NoahCms\Enums\OrderShipmentStatus;
use Sharenjoy\NoahCms\Enums\OrderStatus;
use Sharenjoy\NoahCms\Models\Address;
use Sharenjoy\NoahCms\Models\Order;
use Sharenjoy\NoahCms\Models\Product;
use Sharenjoy\NoahCms\Models\ProductSpecification;
use Sharenjoy\NoahCms\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Sharenjoy\NoahCms\Models\Menu>
 */
class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => fake('en')->randomElement(OrderStatus::cases()),
            'notes' => Arr::random([fake()->sentence(), null, null]),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Order $order) {
            Address::factory()->count(3)->create();
            Product::factory()->create();

            $address = Address::inRandomOrder()->first();
            $specs = ProductSpecification::inRandomOrder()->limit(Arr::random([1, 2, 3, 4]))->get();

            $shipment = $order->shipments()->create([
                'status' => Arr::random(OrderShipmentStatus::cases()),
                'provider' => Arr::random(DeliveryProvider::cases()),
                'delivery_type' => Arr::random(DeliveryType::cases()),
                'name' => fake()->name(),
                'calling_code' => '886',
                'mobile' => fake()->phoneNumber(),
                'country' => $address->country,
                'postcode' => $address->postcode,
                'city' => $address->city,
                'district' => $address->district,
                'address' => $address->address,
            ]);

            // 建立商品項目
            foreach ($specs as $spec) {
                $specData = array_merge(Arr::except($spec->toArray(), ['id', 'product_id', 'order_column', 'is_active', 'created_at', 'updated_at']), [
                    'product_name' => $spec->product->title,
                    'product_image' => $spec->product->img,
                ]);
                $order->items()->create([
                    'product_specification_id' => $spec->id,
                    'order_shipment_id' => $shipment->id,
                    'type' => 'product',
                    'quantity' => 1,
                    'price' => $spec->price ?? Arr::random([1000, 1200, 1800, 1500, 3000, 3500, 800, 1350, 3750, 300, 550]),
                    'discount' => Arr::random([0, 0, 0, 0, 0, 0, 0, -50, -100, -200]),
                    'currency' => 'TWD',
                    'product_details' => $specData,
                ]);
            }

            $invoiceType = [
                [
                    'type' => 'persion',
                ],
                [
                    'type' => 'donate',
                    'donate_code' => '54321',
                ],
                [
                    'type' => 'company',
                    'company_title' => '享享創意有限公司',
                    'company_code' => '69295319',
                ],
                [
                    'type' => 'holder',
                    'holder_type' => 'mobile',
                    'holder_code' => '/R3-.2Q2',
                ],
                [
                    'type' => 'holder',
                    'holder_type' => 'certificate',
                    'holder_code' => '1234567890',
                ]
            ];

            $invoice = $order->invoice()->create(array_merge(Arr::random($invoiceType), [
                'currency' => 'TWD',
            ]));

            $invoicePrices = [
                [
                    'type' => 'product',
                    'value' => $order->items->sum('price'),
                ],
                [
                    'type' => 'delivery',
                    'value' => Arr::random([100, 0]),
                ],
                [
                    'type' => 'product_discount',
                    'value' => $order->items->sum('discount'),
                ],
                [
                    'type' => 'shoppingmoney',
                    'value' => Arr::random([-100, 0, -200, -50]),
                ],
                [
                    'type' => 'point',
                    'value' => Arr::random([-100, 0, 0, 0, 0, 0, -200, -50]),
                    'content' => '使用點數3000點',
                ],
            ];

            foreach ($invoicePrices as $price) {
                $invoice->prices()->create($price);
            }

            CalculatePricesAndUpdateInvoice::run($invoice);

            $order->transaction()->create([
                'invoice_id' => $invoice->id,
                'status' => 'new',
                'provider' => 'tappay',
                'payment_method' => Arr::random(['creditcard', 'atm']),
                'total_price' => $invoice->total_price,
                'currency' => $invoice->currency,
            ]);
        });
    }
}
