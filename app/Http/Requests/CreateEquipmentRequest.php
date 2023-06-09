<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEquipmentRequest extends FormRequest
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
            'equipment_name' => ['required'],
            'code'  => 'required',
            'asset_desc'  => 'required',
            'category'  => 'required',
            'unit' => 'required',
            'model_number'  => 'required',
            'serial_number'  => ['required', 'unique:equipment_attributes,serial_number'],
            'asset_id'  => 'required',
            'remarks'  => 'required',
            'serviceable' => 'required',
            'unserviceable'=> 'required',
            'poor' => 'required'
            
        ];
    }
}
