<?php

namespace Database\Factories;

use App\Models\Rest;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Rest::class;

    public function definition()
    {
        return [
            'start' => $this->faker->time,
            'end' => $this->faker->optional()->time,
            'work_id' => \App\Models\Work::factory(), // Workファクトリを関連付け
        ];
    }
}
