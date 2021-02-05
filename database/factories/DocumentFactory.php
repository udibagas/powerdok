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
            'category' => [$this->faker->word(), $this->faker->word()],
            'number' => $this->faker->randomDigit,
            'version' => $this->faker->randomDigit,
            'departments' => [1, 3, 2],
            'effective_date' => $this->faker->dateTime,
            'expired_date' => $this->faker->dateTime,
            'owner_id' => 1,
            'favorite' => [3, 2, 4]
        ];
    }
}
