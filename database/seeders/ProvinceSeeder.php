<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Province::create([

            'province_name' => 'Bukidnon'

        ]);
        Province::create([

            'province_name' => 'Lanao del Norte'

        ]);
        Province::create([

            'province_name' => 'Camiguin'

        ]);
        Province::create([

            'province_name' => 'Misamis Occidental'

        ]);
        Province::create([

            'province_name' => 'Misamis Oriental'

        ]);
    }
}
