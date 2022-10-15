<?php

namespace Database\Factories;

use App\Models\EquipmentOwned;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Condtion>
 */
class ConditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
           'equipment_owner' => EquipmentOwned::pluck('id')->random(),
           'serviceable'=>$this->faker->randomDigitNotZero(),
           'unusable' => $this->faker->randomDigitNotZero(),
           'poor' => $this->faker->randomDigitNotZero()
        ];
    }
}
