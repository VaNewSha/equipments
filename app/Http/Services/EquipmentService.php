<?php

namespace App\Http\Services;


use App\Exceptions\EquipmentSNMaskException;
use App\Exceptions\EquipmentSNUniqueException;
use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $errorsSN = '';
        $errorsUniq = '';
        $errors = '';

        foreach ($validated as $i => $item) {
            if (!$this->checkSerialNumberMask($item['equipment_types_id'] ,$item['sn'])) {
                $errorsSN = $errorsSN . ' ' . $item['sn'];
                unset($validated[$i]);
            }
        }

        foreach ($validated as $i => $item) {
            if (!$this->checkSerialNumberUniqueness($item['sn'])) {
                $errorsUniq = $errorsUniq . ' ' . $item['sn'];
                unset($validated[$i]);
            }
        }

        if($errorsSN != '' && $errorsUniq != '') {
            $errors = 'Не прошли по маске Серийного номера:' . $errorsSN
                . '. Не прошли по уникальности номера:' . $errorsUniq;
        } else if ($errorsSN != '') {
            $errors = 'Не прошли по маске Серийного номера:' . $errorsSN;
        } else if ($errorsUniq != '') {
            $errors = 'Не прошли по уникальности номера:' . $errorsUniq;
        }


        $json = [];

        if (count($validated) != 0) {
            foreach ($validated as $item) {
                $equipment = new Equipment();

                $equipment->equipment_types_id = $item['equipment_types_id'];
                $equipment->sn = $item['sn'];
                $equipment->note = $item['note'];

                $equipment->save();
                $json[] = $equipment->refresh();
            }
        }

        return ['data' => $json, 'errors' => $errors];
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
        $maskSN = EquipmentType::query()->where('id', '=', $equipmentTypeId)->value('mask_sn');
        $regMaskSN = '';

        foreach (str_split($maskSN) as $char) {
            $regMaskSN = $regMaskSN . EquipmentType::TYPES_SN[$char];
        }

        $regMaskSN = '/\A' . $regMaskSN . '\Z/';

        preg_match($regMaskSN, $serialNumber, $matches);

        if ($matches == []) {
            return false;
        }

        return true;
    }

}
