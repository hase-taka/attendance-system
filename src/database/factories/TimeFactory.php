<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Time::class;

    public function definition()
    {
        return [
            'user' => $this->faker->,
            '' => $this->faker->,
            '' => $this->faker->,
            '' => $this->faker->,
        ];
    }
}
