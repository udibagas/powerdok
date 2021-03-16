<?php

namespace Database\Factories;

use App\Models\DocumentQuiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentQuizFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DocumentQuiz::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'document_id' => rand(1, 10),
            'question' => $this->faker->paragraphs(3, true),
            'choices' => $this->faker->paragraphs(4),
            'correct_answer' => rand(0, 3),
        ];
    }
}
