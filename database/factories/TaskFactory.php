<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(10),
            'user_id' => rand(1, 100),
            'due_date' => $this->faker->date('Y-m-d', now()->addMonth()->format('Y-m-d')),
            'priority' => rand(0, 3),
            'status' => rand(0, 6),
            'custom_fields' => ['Field' => 'Value'],
        ];
    }
}
