<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;


trait Approvals
{

    protected $code = 0;
    public function MustApproved()
    {

        return $this->connect();
    }

    public function connect()
    {
        $code = $this->generateUniqueCode();
        return $this->create_tmp($code);
    }

   
    public function insert()
    {
    }

    public function generateUniqueCode()
    {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 6;

        $code = '';

        while (strlen($code) < 6) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code . $character;
        }

        if (Trainer::where('code', $code)->exists()) {
            $this->generateUniqueCode();
        }

        return $code;
    }
}
