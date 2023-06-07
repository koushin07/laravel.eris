<?php

namespace App\Rules;

use App\Models\EquipmentAttribute;
use Illuminate\Contracts\Validation\Rule;

class AttributeExistRule implements Rule
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
        // dd($value);
        $attr = EquipmentAttribute::where([
            
            ['code', $value['code']],
            ['category', $value['category']],
            ['unit', $value['unit']],
            ['model_number', $value['model_number']],
            ['serial_number', $value['serial_number']],
            ['asset_id', $value['asset_id']],
        ])->exists();

        if($attr){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Attributes not found.';
    }
}
