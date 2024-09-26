<?php

namespace Database\Factories;

use App\Models\Income;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    protected $model = Income::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'description' => $this->faker->sentence,
            'date' => $this->faker->date(),
        ];
    }
}
