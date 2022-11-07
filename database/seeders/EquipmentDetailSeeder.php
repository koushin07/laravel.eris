<?php

namespace Database\Seeders;

use App\Models\EquipmentDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       EquipmentDetail::factory(5000)->create();
    }
}
