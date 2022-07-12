<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'equipmentTypeId' => [
                'required',
                'integer',
            ],
            'sn' => [
                'string',
                'min:1',
                'max:10',
            ],
            'note' => [
                'nullable',
                'string',
            ],
        ];
    }
}
