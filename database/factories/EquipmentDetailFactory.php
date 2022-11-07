<?php

namespace Database\Factories;

use App\Models\EquipmentOwned;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EquipmentDetail>
 */
class EquipmentDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'equipment_owner'=>EquipmentOwned::pluck('id')->random(),
            'serviceable'=>$this->faker->numberBetween(1, 500),
            'unusable'=>$this->faker->numberBetween(1, 500),
            'poor'=>$this->faker->numberBetween(1, 500),
        ];
    }
}
