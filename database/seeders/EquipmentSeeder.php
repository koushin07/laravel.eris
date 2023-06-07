<?php

namespace Database\Seeders;

use Ramsey\Uuid\Type\Integer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Container\Container;
use Faker\Generator;
use App\Models\Role;
use App\Models\Office;
use App\Models\EquipmentOwned;
use App\Models\EquipmentDetail;
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
                'name' => $tool,
                'recieved_at' => $this->faker->dateTimeBetween('-2 years', '+1 year')

            ]);
        }


        $equipment = Equipment::all();


        $office = Office::whereNot('role_id', Role::PROVINCE)->whereNot('role_id', Role::ADMIN)->get();
        $count = EquipmentAttribute::count();
        $attrs = EquipmentAttribute::all();
        $amount = 0;
        while ($count > $amount) {
            EquipmentOwned::create([
                'equipment_id' => $equipment->random()->id,
                'office_id' => $office->random()->id,
                'equipment_attrs' =>$attrs->random()->id,

            ]);
            $amount++;
        }

        $owned = EquipmentOwned::all();
        $owned->each(function ($ow) {
            EquipmentDetail::create([
                'equipment_owner' => $ow->id,
                'serviceable' => rand(1, 500),
                'unserviceable' => rand(1, 500),
                'poor' => rand(1, 500),
            ]);
        });



    }
}
