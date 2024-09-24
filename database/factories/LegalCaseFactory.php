<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subject;
use App\Models\Trial;
use App\Models\User;
use App\Models\LegalCase;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LegalCase>
 */
class LegalCaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
            'origin' => $this->faker->city(),
            'context' => $this->faker->paragraph(),
            'analysis' => $this->faker->text(),
            'resolution' => $this->faker->text(),
            'note' => $this->faker->paragraph(),
            'user_id' => User::all()->random()->id,
            'trial_id' => Trial::all()->random()->id,
        ];
    }
    public function withTags()
    {
        return $this->afterCreating(function (LegalCase $case) {
            $tags = $this->faker->words(3); // generate 3 random tags
            $case->attachTags($tags);
        });
    }

}
