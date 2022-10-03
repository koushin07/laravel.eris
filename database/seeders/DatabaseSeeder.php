<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Municipality;
use App\Models\MunicipalityTransaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@admin.admin',
        //     'municipality_id'=>null,
        //     'province_id'=>null,
        //     'password' => bcrypt("admin"), // password
        //     'role' => 'rdrrmc',
        // ]);
        //    $this->call(ProvinceSeeder::class);
        //  Municipality::factory(10)->create();

        //  $this->call(MunicipalityTransactionSeeder::class);
         $this->call(equipmentSeeder::class);
        // $this->call(MunicipalityTransactionSeeder::class);


    }
}
