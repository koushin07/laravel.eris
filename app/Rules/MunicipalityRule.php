<?php

namespace App\Rules;

use App\Models\Municipality;
use Illuminate\Contracts\Validation\Rule;

use function PHPUnit\Framework\isEmpty;

class MunicipalityRule implements Rule
{
    
    public function passes($attribute, $value)
    {

       return  Municipality::find($value) ? true : false; 
  
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Municipality is not in the list';
    }
}
