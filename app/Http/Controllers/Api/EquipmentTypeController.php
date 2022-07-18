<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentStoreCollection;
use App\Http\Services\EquipmentTypeService;
use Illuminate\Http\Request;

class EquipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param EquipmentTypeService $service
     * @return EquipmentStoreCollection
     */
    public function getEquipmentType(Request $request, EquipmentTypeService $service): EquipmentStoreCollection
    {
        $data = $service->getEquipmentTypesList($request);

        return new EquipmentStoreCollection($data);
    }

}
