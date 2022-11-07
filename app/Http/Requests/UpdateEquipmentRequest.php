<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipmentRequest extends FormRequest
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
            'equipment_id'=> 'required',
            'equipment_name' => 'required',
            'code'  => 'string',
            'asset_desc'  => 'string',
            'category'  => 'string',
            'quantity'  => 'Integer',
            'unit' => 'Integer',
            'model_number'  => 'Integer',
            'serial_number'  => 'Integer',
            'serviceable'  => 'Integer',
            'unusable'  => 'Integer',
            'poor'  => 'Integer',
            'asset_id'  => 'Integer',
            'remarks'  => 'string',
        ];
    }
}
