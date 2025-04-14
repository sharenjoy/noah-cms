<?php

namespace Sharenjoy\NoahCms\Database\Factories;

use Sharenjoy\NoahCms\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Translatable\HasTranslations;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Sharenjoy\NoahCms\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'content' => $this->getContent(),
            'slug' => fake()->unique()->word(10),
            'img' => \Spatie\MediaLibrary\MediaCollections\Models\Media::inRandomOrder()->first()->id,
            'is_active' => fake()->boolean(70),
            'published_at' => now(),
        ];
    }

    protected function getTitle(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(Post::class))) {
            return [
                'en' => fake('en')->sentence(),
                'zh_TW' => fake()->sentence(),
            ];
        }

        return fake()->sentence();
    }

    protected function getDescription(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(Post::class))) {
            return [
                'en' => fake('en')->paragraph(),
                'zh_TW' => fake()->paragraph(),
            ];
        }

        return fake()->paragraph();
    }

    protected function getContent(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(Post::class))) {
            return [
                'en' => fake('en')->text(),
                'zh_TW' => fake()->text(),
            ];
        }

        return fake()->text();
    }
}
