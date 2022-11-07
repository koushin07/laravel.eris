<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=EquipmentOwned>
 */
class EquipmentOWnedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'equipment_id' =>Equipment::pluck('id')->random(),
            'office_id' => Office::pluck('id')->random(),
        ];
    }
}