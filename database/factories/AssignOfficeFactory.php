<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssignOffice>
 */
class AssignOfficeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $provinces = [
            'Bukidnon',
            'Lanao del Norte',
            'Camiguin',
            'Misamis Occidental',
            'Misamis Oriental'
        ];
        return [
           'municipality' => $this->faker->city(),
           'province' =>$this->faker->randomElement($provinces),
        ];
    }
}
