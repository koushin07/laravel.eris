<?php

namespace Database\Seeders;

use Ramsey\Uuid\Type\Integer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Container\Container;
use Faker\Generator;
use App\Models\EquipmentAttribute;
use App\Models\Equipment;

class EquipmentSeeder extends Seeder
{

    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tools = array(
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
        );


        foreach ($tools as $tool) {
            Equipment::create([
                'name' => $tool
            ]);
        }
        $equipment = Equipment::all();
        $amount = 1;

        do {
            EquipmentAttribute::create([
                'equipment_id' => $equipment->random()->id,
                'code' => $this->faker->randomDigitNotZero(),
                'asset_desc' => $this->faker->sentence(),
                'category' => $this->faker->sentence(),
                'unit' => $this->faker->randomDigitNotZero(),
                'model_number' => $this->faker->randomDigitNotZero(),
                'serial_number' => $this->faker->randomDigitNotZero(),
                'asset_id' => $this->faker->randomNumber(),
                'remarks' => $this->faker->sentence(),
            ]);
            $amount++;
        } while ($amount <= 1000);
    }
}
