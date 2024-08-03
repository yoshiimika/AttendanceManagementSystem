<?php

namespace Database\Factories;

use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Work::class;

    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'start' => $this->faker->time,
            'end' => $this->faker->optional()->time,
            'user_id' => \App\Models\User::factory(), // Userファクトリを関連付け
        ];
    }
}
