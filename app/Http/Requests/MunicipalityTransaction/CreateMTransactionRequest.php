<?php

namespace App\Http\Requests\MunicipalityTransaction;

use App\Rules\MunicipalityRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateMTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'equipment_id' => 'required',
            'municipality_id' => ['required'],
            'quantity'
        ];
    }
}
