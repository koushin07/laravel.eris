<?php

namespace Database\Seeders;

use App\Models\BorrowingDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BorrowingDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BorrowingDetails::factory(1)->create();
    }
}
