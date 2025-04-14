<?php

namespace Sharenjoy\NoahCms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sharenjoy\NoahCms\Models\Address;
use Sharenjoy\NoahCms\Models\User;
use Spatie\Translatable\HasTranslations;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Sharenjoy\NoahCms\Models\Menu>
 */
class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'country' => fake('en')->country(),
            'city' => fake('en')->city(),
            'district' => fake('en')->state(),
            'address' => fake('en')->streetAddress(),
            'postcode' => fake('en')->postcode(),
        ];
    }
}
