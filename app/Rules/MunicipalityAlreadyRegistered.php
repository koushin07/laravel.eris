<?php

namespace App\Rules;

use App\Models\AssignOffice;
use App\Models\Office;
use Illuminate\Contracts\Validation\Rule;

class MunicipalityAlreadyRegistered implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $assign = AssignOffice::find($value);
        if(is_null($assign)){
            return false;
        }

        $office = Office::where('assign', $assign->id)->first();
        if(!is_null($office)){
            if($office->must_reset_password == 0){
                return false;
            }
          
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Sorry Account Already Registered.';
    }
}
