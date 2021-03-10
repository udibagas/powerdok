<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Document::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'categories' => [$this->faker->word(), $this->faker->word()],
            'tags' => [$this->faker->word(), $this->faker->word()],
            'departments' => [1, 3, 2],
            'favourites' => [3, 2, 4],
            'type' => rand(0, 1),
            'is_public' => !!rand(0, 1)
        ];
    }
}
