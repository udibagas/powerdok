<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $title = $this->faker->sentence();
        $slug = Str::slug($title);

        return [
            'title' => $title,
            'slug' => $slug,
            'tags' => [$this->faker->word(), $this->faker->word()],
            'categories' => [$this->faker->word(), $this->faker->word()],
            'number' => $this->faker->randomDigit,
            'version' => $this->faker->randomDigit,
            'departments' => [1, 3, 2],
            'effective_date' => $this->faker->dateTime,
            'expired_date' => $this->faker->dateTime,
            'owner_id' => 1,
            'favourites' => [3, 2, 4],
            'type' => $this->faker->randomElement([0, 1])
        ];
    }
}
