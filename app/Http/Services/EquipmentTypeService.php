<?php

namespace App\Http\Services;

use App\Models\EquipmentType;
use Illuminate\Http\Request;

class EquipmentTypeService
{
    /**
     * Get filtered equipment type data
     *
     * @param Request $request
     * @return mixed
     */
    public function getEquipmentTypesList(Request $request)
    {
        $filter = $request['filter'];

        if ($filter !== '') {
            $equipmentTypes = EquipmentType::query()
                ->Where('id', 'LIKE', '%' . $filter . '%')
                ->orWhere('name', 'LIKE', '%' . $filter . '%')
                ->orWhere('mask_sn', 'LIKE', '%' . $filter . '%')
                ->paginate();
        } else {
            $equipmentTypes = EquipmentType::paginate();
        }

        return $equipmentTypes;
    }
}
