<?php

// CategorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::inRandomOrder()->first();

        $categories = [
            //expense categories
            ['name' => 'Food', 'type' => 'expense', 'user_id' => $user->id],
            ['name' => 'Transport', 'type' => 'expense', 'user_id' => $user->id],
            ['name' => 'Entertainment', 'type' => 'expense', 'user_id' => $user->id],
            ['name' => 'Health', 'type' => 'expense', 'user_id' => $user->id],
            ['name' => 'Housing', 'type' => 'expense', 'user_id' => $user->id],

            //income categories
            ['name' => 'Salary', 'type' => 'income', 'user_id' => $user->id],
            ['name' => 'Freelance', 'type' => 'income', 'user_id' => $user->id],
            ['name' => 'Investments', 'type' => 'income', 'user_id' => $user->id],
            ['name' => 'Rentals', 'type' => 'income', 'user_id' => $user->id],
            ['name' => 'Other', 'type' => 'income', 'user_id' => $user->id],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
