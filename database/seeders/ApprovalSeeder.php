<?php

namespace Database\Seeders;

use Illuminate\Container\Container;
use Faker\Generator;
use App\Models\Approval;
use App\Models\Borrowing;
use App\Models\BorrowingDetails;
use App\Models\Equipment;
use App\Models\EquipmentBorrow;
use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApprovalSeeder extends Seeder
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
        $inicident = [
            'Hurricanes',
            'tropical storms',
            'Landslides ',
            'debris flow',
            'Tornadoes',
            'Tsunamis',
            'Wildfire',
            'Sinkholes',
            'Thunderstorms',
            'flooding',
            'Earthquake',
            'Volcanoes'
        ];
        Approval::factory(1000)->create()->each(function($ap) use($inicident){
            $owner = $this->generateRandom();
           
         
           
            $borrowing = Borrowing::create([
                'approval_id' =>$ap->id,
                'owner' => $owner,
            ]);
            $detail = BorrowingDetails::create([
                'borrowing_id' =>$borrowing->id,
                'incident_id' =>'IN-' . rand(pow(10, 5-1), pow(10, 5)-1),
                'incident' =>$this->faker->randomElement($inicident)
            ]);
            $equipment_borrow = EquipmentBorrow::create([
                'equipment_id' =>Equipment::skip(12)->limit(10)->pluck('id')->random(),
                'quantity'=>rand(1,20),
                'acquired' => 0,
                'detail_id' =>$detail->id,

            ]);
        });
    }

    public function generateRandom()
    {
       return Office::limit(10)->pluck('id')->random();
    }
}
