<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentAttribute>
 */
class EquipmentAttrFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'code' => $this->faker->randomDigitNotZero(),
            'asset_desc' => $this->faker->sentence(),
            'category' => $this->faker->sentence(),
            'unit' => $this->faker->randomDigitNotZero(),
            'model_number' => $this->faker->randomDigitNotZero(),
            'serial_number' => $this->faker->randomDigitNotZero(),
            'asset_id' => $this->faker->randomNumber(),
            'remarks' => $this->faker->sentence(),
        ];
    }
}
