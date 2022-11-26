<?php

namespace App\Rules;

use App\Models\AssignOffice;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Office;

class ProvinceMustExistRule implements Rule
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
        // dd(Office::join('assign_offices', 'assign_offices.id', '=', 'offices.assign')->where('offices.'));
        $assign = AssignOffice::find($value);

        // dd($assign);
        // $office = Office::where('assign', $assign->id)->exists();
        // $office = Office::join('assign_offices', 'assign_offices.id', '=', 'offices.assign')->where('assign_offices.province', 'Misamis_Oriental')->get();
        $office = AssignOffice::where('province', $assign->province)->whereNull('municipality')->first();

        return Office::where('assign', $office->id)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Province is not created Yet.';
    }
}
