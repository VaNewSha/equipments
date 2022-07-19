<?php

namespace App\Http\Requests;

use App\Http\Services\EquipmentService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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
            'data.*.equipment_types_id' => [
                'required',
                'integer',
            ],
            'data.*.sn' => [
                'string',
                'min:10',
                'max:10',
            ],
            'data.*.note' => [
                'nullable',
                'string',
            ],
        ];
    }

    /**
     * Надстройка экземпляра валидатора.
     *
     * @param  Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $data = $validator->getData();
            $service = new EquipmentService();

            foreach ($data['data'] as $item) {
                if (!$service->checkSerialNumberMask($item['equipment_types_id'] ,$item['sn'])) {
                    $validator->errors()->add($item['sn'], 'не проходит по маске номера');
                }
                if (!$service->checkSerialNumberUniqueness($item['sn'])) {
                    $validator->errors()->add($item['sn'], ' не является уникальным');
                }
            }
        });
    }
}
