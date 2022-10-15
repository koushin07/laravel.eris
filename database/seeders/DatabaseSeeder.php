<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AssignOffice;
use Illuminate\Database\Seeder;
use Database\Seeders\ReturnedSeeder;
use App\Models\Office;
use App\Models\MunicipalityTransaction;
use App\Models\Municipality;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

     
        // $this->call(AssignOfficeSeeder::class);
        // $this->call(RoleSeeder::class);
        // Office::create([
        //     'name' => 'municipality',
        //     'email' => 'municipality@rdrrmc.com',
        //     'password' => bcrypt("municipality"), // password
        //     'assign' => 1, 
        //     'role_id' => 1,
        // ]);
        // Office::create([
        //     'name' => 'naawan',
        //     'email' => 'naawan@rdrrmc.com',
        //     'password' => bcrypt("naawan"), // password
        //     'assign' => 1, 
        //     'role_id' => 1,
        // ]);
        // AssignOffice::create([
        //     'municipality'=> null,
        //     'province' => 'Lanao del Norte'
        // ]);
        // Office::create([
        //     'name' => 'naawan',
        //     'email' => 'province@rdrrmc.com',
        //     'password' => bcrypt("province"), // password
        //     'assign' => 11, 
        //     'role_id' => 2,
        // ]);
        // $this->call(equipmentSeeder::class);
        // $this->call(EquipmentOWnedSeeder::class);
        // $this->call(BorrowingSeeder::class);
        // $this->call(BorrowingDetailsSeeder::class);
        // $this->call(ReturnedSeeder::class);
        // $this->call(ConditionSeeder::class);
    }
}
