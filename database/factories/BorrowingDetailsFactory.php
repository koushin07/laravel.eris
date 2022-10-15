<?php

namespace Database\Factories;

use App\Models\Borrowing;
use App\Models\EquipmentOwned;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BorrowingDetails>
 */
class BorrowingDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'equipment_id' => EquipmentOwned::pluck('id')->random(),
            'borrowing_id' => Borrowing::pluck('id')->random(),
            'quantity' => $this->faker->randomDigitNotZero()
        ];
    }
}
