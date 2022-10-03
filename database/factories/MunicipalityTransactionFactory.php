<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MunicipalityTransaction>
 */
class MunicipalityTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'equipment_id' => Equipment::pluck('id')->random(),
            'municipality_id' => Municipality::pluck('id')->random(),
            'quantity' => $this->faker->randomDigitNotZero(),
        ];
    }
}
