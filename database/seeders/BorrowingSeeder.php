<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Container\Container;
use Faker\Generator;
use App\Models\Role;
use App\Models\Office;
use App\Models\EquipmentOwned;
use App\Models\EquipmentAttribute;
use App\Models\Equipment;
use App\Models\Borrowing;

class BorrowingSeeder extends Seeder
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
       
    }
}
