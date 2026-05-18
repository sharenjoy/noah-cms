<?php

namespace Sharenjoy\NoahCms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahCms\Models\Tag;
use Spatie\Translatable\HasTranslations;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->getName(),
            'slug' => fake()->unique()->word(10),
            'type' => fake()->randomElement(['post', 'product']),
        ];
    }

    protected function getName(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(Tag::class))) {
            return [
                'en' => fake('en')->name(),
                'zh_TW' => fake()->name(),
            ];
        }

        return fake()->name();
    }
}
