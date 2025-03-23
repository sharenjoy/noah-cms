<?php

namespace Sharenjoy\NoahCms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Translatable\HasTranslations;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Sharenjoy\NoahCms\Models\Menu>
 */
class MenuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'content' => $this->getContent(),
            'slug' => fake()->unique()->word(10),
            'is_active' => fake()->boolean(70),
            'published_at' => now(),
        ];
    }

    protected function getTitle(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(\Sharenjoy\NoahCms\Models\Menu::class))) {
            return [
                'en' => fake('en')->sentence(),
                'zh_TW' => fake()->sentence(),
            ];
        }

        return fake()->sentence();
    }

    protected function getDescription(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(\Sharenjoy\NoahCms\Models\Menu::class))) {
            return [
                'en' => fake('en')->paragraph(),
                'zh_TW' => fake()->paragraph(),
            ];
        }

        return fake()->paragraph();
    }

    protected function getContent(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(\Sharenjoy\NoahCms\Models\Menu::class))) {
            return [
                'en' => fake('en')->text(),
                'zh_TW' => fake()->text(),
            ];
        }

        return fake()->text();
    }
}
