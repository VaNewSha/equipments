<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            '*.*.equipment_types_id' => [
                'required',
                'integer',
            ],
            '*.*.sn' => [
                'string',
                'min:10',
                'max:10',
            ],
            '*.*.note' => [
                'nullable',
                'string',
            ],
        ];
    }
}
