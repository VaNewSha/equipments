<?php

namespace App\Http\Services;


use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class EquipmentService
{
    /**
     * Get filtered equipment data
     *
     * @param Request $request
     * @return mixed
     */
    public function getEquipmentList(Request $request)
    {
        $filter = $request['filter'];
        $perPage = 10;

        if ($filter !== '') {
            $equipments = Equipment::query()
                ->Where('sn', 'LIKE', '%' . $filter . '%')
                ->orWhere('note', 'LIKE', '%' . $filter . '%')
                ->paginate($perPage);
        } else {
            $equipments = Equipment::paginate($perPage);
        }

        return $equipments;
    }

    /**
     * Get filtered equipment data
     *
     * @param array $validated
     * @param Equipment $equipment
     * @return Equipment
     */
    public function updateEquipmentData(array $validated, Equipment $equipment): Equipment
    {
        if (!$this->checkSerialNumber($validated['equipmentTypeId'] ,$validated['sn'])) {
            return $equipment;
        }

        $equipment->equipment_types_id = $validated['equipmentTypeId'];
        $equipment->sn = $validated['sn'];
        $equipment->note = $validated['note'];

        $equipment->save();

        return $equipment;
    }

    /**
     * Checking serial number for correctness and uniqueness
     *
     * @param int $equipmentTypeId
     * @param string $serialNumber
     * @return bool
     */
    public function checkSerialNumber(int $equipmentTypeId, string $serialNumber): bool
    {
        $maskSN = EquipmentType::TYPES_SN[$equipmentTypeId];
        preg_match($maskSN, $serialNumber, $matches);

        if ($matches == []) {
            return false;
        }

        $uniqueness = Equipment::query()->Where('sn', 'LIKE',  $serialNumber)->get();
        if (count($uniqueness) != 0) {
            return false;
        }



        return true;
    }

}
