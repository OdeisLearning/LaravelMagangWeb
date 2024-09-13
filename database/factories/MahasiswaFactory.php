<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            ##'user_id','kelas_id','nim','name','tempat_lahir','tanggal_lahir','edit'
            'user_id' => User::factory(),
            'kelas_id' => 2,//fake()->numberBetween(1,5),
            'nim'=> fake()->numerify('#########'),
            'name'=> fake()->unique()->name(),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'edit' => FALSE
        ];
    }
    public function no_kelas(): static
    {
        return $this->state(fn (array $attributes) => [
            'kelas_id' => null,
        ]);
    }
}
