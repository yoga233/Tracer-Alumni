<?php
namespace Database\Factories;

use App\Models\Alumni;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumniFactory extends Factory
{
    protected $model = Alumni::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'major' => $this->faker->randomElement(['Informatics', 'Computer Science', 'Information Systems']),
            'graduation_year' => $this->faker->year('now'),
            'employment_status' => $this->faker->randomElement(['Employed', 'Unemployed', 'Freelancer', 'Entrepreneur', 'Studying']),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->city(),
        ];
    }
}
