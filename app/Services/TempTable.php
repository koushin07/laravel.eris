<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TempTable
{

    public $code = 0;
    public function MustApproved()
    {

        $this->connect();


        return $this->insert($this->code);
    }

    public function connect()
    {
        $code = $this->generateUniqueCode();
        return $this->create_tmp($this->code);
    }

    protected function create_tmp($code)
    {

        return DB::statement(
            "
                CREATE TEMPORARY TABLE " . $code . "  
                                 (
                                    name     varchar(255),
                                    confirmation tinyint(255),
                                    cancellation tinyint(225),
                                    data varchar(255)
                                    );
                                
            "
        );
    }
    public function insert($code)
    {
        return DB::table($code)->insert(['name'=> 'miko', 'confirmation'=> 0, 'cancellation' => 0, 'data'=>'[{name: "yes"}]']);
    }

    public function generateUniqueCode()
    {
        return $this->code = uniqid();
    }
    public function columns($code)
    {
        return DB::select('SELECT * FROM ' . $code);
    }
}
