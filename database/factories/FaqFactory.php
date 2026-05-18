<?php

namespace Sharenjoy\NoahCms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Sharenjoy\NoahCms\Models\Faq;
use Spatie\Translatable\HasTranslations;

/**
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = Faq::class;

    public function definition(): array
    {
        return [
            'question' => $this->getQuestion(),
            'answer' => $this->getAnswer(),
            'is_active' => fake()->boolean(70),
        ];
    }

    protected function getQuestion(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(Faq::class))) {
            return [
                'en' => fake('en')->sentence().'?',
                'zh_TW' => fake()->sentence().'?',
            ];
        }

        return fake()->sentence().'?';
    }

    protected function getAnswer(): array|string
    {
        if (in_array(HasTranslations::class, class_uses(Faq::class))) {
            return [
                'en' => fake('en')->paragraph(),
                'zh_TW' => fake()->paragraph(),
            ];
        }

        return fake()->paragraph();
    }
}
