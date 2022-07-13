<?php

namespace App\Http\Services;


use App\Exceptions\EquipmentSNMaskException;
use App\Exceptions\EquipmentSNUniqueException;
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
     * Create a newly equipments.
     *
     * @param array $validated
     * @return array $json
     * @throws EquipmentSNUniqueException
     * @throws EquipmentSNMaskException
     */
    public function createEquipments(array $validated): array
    {
        $errors = '';

        foreach ($validated as $item) {
            if (!$this->checkSerialNumberMask($item['equipment_types_id'] ,$item['sn'])) {
                $errors = $errors . ' ' . $item['sn'];
            }
        }

        if ($errors != '') {
            throw new EquipmentSNMaskException('Серийный номер(а): ' . $errors
                . ' не проходит по маске оборудования!');
        }

        foreach ($validated as $item) {
            if (!$this->checkSerialNumberUniqueness($item['sn'])) {
                $errors = $errors . ' ' . $item['sn'];
            }
        }

        if ($errors != '') {
            throw new EquipmentSNUniqueException('Серийный номер(а): ' . $errors
                . ' не вляется уникальным!');
        }

        $json = [];

        foreach ($validated as $item) {
            $equipment = new Equipment();

            $equipment->equipment_types_id = $item['equipment_types_id'];
            $equipment->sn = $item['sn'];
            $equipment->note = $item['note'];

            $equipment->save();
            $json[] = $equipment->refresh();
        }

        return $json;
    }

    /**
     * Get filtered equipment data
     *
     * @param array $validated
     * @param Equipment $equipment
     * @return Equipment
     * @throws EquipmentSNUniqueException
     * @throws EquipmentSNMaskException
     */
    public function updateEquipmentData(array $validated, Equipment $equipment): Equipment
    {
        if (!$this->checkSerialNumberMask($validated['equipmentTypeId'] ,$validated['sn'])) {
            throw new EquipmentSNMaskException('Серийный номер: ' . $validated['sn']
                . ' не проходит по маске оборудования!');
        }

        if ($equipment->equipment_types_id !== $validated['equipmentTypeId'] && !$this->checkSerialNumberUniqueness($validated['sn'])) {
            throw new EquipmentSNUniqueException('Серийный номер: ' . $validated['sn']
                . ' не вляется уникальным!');
        }

        $equipment->equipment_types_id = $validated['equipmentTypeId'];
        $equipment->sn = $validated['sn'];
        $equipment->note = $validated['note'];

        $equipment->save();

        return $equipment;
    }

    /**
     * Checking serial number for uniqueness
     *
     * @param string $serialNumber
     * @return bool
     */
    public function checkSerialNumberUniqueness(string $serialNumber): bool
    {
        $uniqueness = Equipment::query()->Where('sn', 'LIKE',  $serialNumber)->get();
        if (count($uniqueness) != 0) {
            return false;
        }

        return true;
    }

    /**
     * Checking serial number for correctness
     *
     * @param int $equipmentTypeId
     * @param string $serialNumber
     * @return bool
     */
    public function checkSerialNumberMask(int $equipmentTypeId, string $serialNumber): bool
    {
        $maskSN = EquipmentType::TYPES_SN[$equipmentTypeId];
        preg_match($maskSN, $serialNumber, $matches);

        if ($matches == []) {
            return false;
        }

        return true;
    }

}
