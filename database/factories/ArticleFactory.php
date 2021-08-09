<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tags = ['Technology', 'Automobile', 'Programming', 'Science', 'Web', 'internet', 'media', 'security'];

        return [
            'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'tags' => $this->faker->randomElement($tags) . ', ' . $this->faker->randomElement($tags) . ', ' . $this->faker->randomElement($tags),
            'description' => $this->faker->paragraphs(4, true),

        ];
    }
}
