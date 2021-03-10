<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DocumentVersion;

class DocumentVersionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DocumentVersion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'document_id' => rand(1, 10),
            'number' => $this->faker->randomDigit,
            'version' => $this->faker->randomDigit,
            'effective_date' => $this->faker->dateTime,
            'expired_date' => $this->faker->dateTime,
            'body' => $this->faker->paragraph(10),
            'owner_id' => 1,
        ];
    }
}
