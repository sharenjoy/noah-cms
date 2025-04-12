<?php

namespace Sharenjoy\NoahCms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sharenjoy\NoahCms\Models\Brand;
use Spatie\Translatable\HasTranslations;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'content' => $this->getContent(),
            'slug' => fake()->unique()->word(10),
            'is_active' => fake()->boolean(70),
        ];
    }

    protected function getTitle(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(Brand::class))) {
            return [
                'en' => fake('en')->sentence(),
                'zh_TW' => fake()->sentence(),
            ];
        }

        return fake()->sentence();
    }

    protected function getDescription(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(Brand::class))) {
            return [
                'en' => fake('en')->paragraph(),
                'zh_TW' => fake()->paragraph(),
            ];
        }

        return fake()->paragraph();
    }

    protected function getContent(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(Brand::class))) {
            return [
                'en' => fake('en')->text(),
                'zh_TW' => fake()->text(),
            ];
        }

        return fake()->text();
    }
}
