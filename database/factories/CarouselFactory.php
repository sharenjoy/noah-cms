<?php

namespace Sharenjoy\NoahCms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sharenjoy\NoahCms\Models\Carousel;
use Spatie\Translatable\HasTranslations;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Carousel>
 */
class CarouselFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Carousel::class;

    public function definition(): array
    {
        return [
            'title' => $this->getName(),
            'description' => $this->getDescription(),
            'img' => \Spatie\MediaLibrary\MediaCollections\Models\Media::inRandomOrder()->first()->id,
            'is_active' => fake()->boolean(70),
        ];
    }

    protected function getName(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(Carousel::class))) {
            return [
                'en' => fake('en')->word(),
                'zh_TW' => fake()->word(),
            ];
        }

        return fake()->word();
    }

    protected function getDescription(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(Carousel::class))) {
            return [
                'en' => fake('en')->paragraph(),
                'zh_TW' => fake()->paragraph(),
            ];
        }

        return fake()->paragraph();
    }
}
