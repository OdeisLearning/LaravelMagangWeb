<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dosen>
 */
class DosenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            ##['user_id','kelas_id','kode_dosen','nip','name'];
            'user_id' => User::factory()->dosen(),
            'kelas_id' => null,
            'kode_dosen' => fake()->numberBetween(1,5),
            'nip'=> fake()->numerify('################'),
            'name'=> fake()->unique()->name(),
        ];
    }
    public function wali(): static
    {
        return $this->state(fn (array $attributes) => [
            'kelas_id' => Kelas::factory(),
        ]);
    }
}
