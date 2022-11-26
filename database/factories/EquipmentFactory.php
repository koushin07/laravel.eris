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
        $tools = [
            'SILICON MANUAL RESUSCITATOR',
            'CPR POCKET MASKe',
            'AMARADA SOLAS LIFE VEST',
            'ALUMINUM FOLDING STRETCHER W/ BAG',
            '02 BACKPACK FIRST AID TRAUMA KIT',
            'EMERGENCY SPINE BOARD X-RAY CLAIRVOYANT',
            'MEGAPHONE BIG',
            'ADJUSTABLE TRACTION SPLINT',
            'HELMET',
            'TRAFFIC VEST',
            'CADAVER BAG',
            'BANDAGE',
            'SWEAT SHIRT UNIFORM',
            'WHISTLE FOX 40',
            'HAND GLOVES',
            'LED HEAD LAMP',
            'MULTI FUNCTIONAL DIMMING HY-1008',
            'RAINCOAT',
            'RUBBER BOOTS',
            'FIRE EXTINGUISHER',
        ];

        return [
            'name' => $this->faker->randomElement($tools),
        ];
    }
}
