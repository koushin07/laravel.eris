<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Municipality;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tools =[
            'Axe for use of SAFG',
            'Aerial Flare',
            'Aircraft Assault Ladder',
            'Ascending Device',
            'Assault Rescue Harness',
            'Basket Stretcher',
            'Bolt Cutter, Heavy Duty',
            'Cervical Extrication Collar',
            'Carabiners (Snap Link)',
            'Door Jamb Spreader',
            'Emergency Stretcher',
        ];

        return [
           'municipality_id'=>Municipality::pluck('id')->random(),
           'equipment_name'=>$this->faker->randomElement($tools),
            'code'=>$this->faker->randomDigitNotZero(),
            'asset_desc'=>$this->faker->sentence(),
            'category'=>$this->faker->sentence(),
            'unit'=>$this->faker->randomDigitNotZero(),
            'model_number'=>$this->faker->randomDigitNotZero(),
            'serial_number'=>$this->faker->randomDigitNotZero(),
            'status'=>$this->faker->randomElement(['serviceable', 'poor', 'unusable']),
            'asset_id'=>$this->faker->randomNumber(),
            'remarks'=>$this->faker->sentence(),
            'quantity'=>$this->faker->randomDigitNotZero(),
            
        ];
    }
}
