<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseCollection;
use App\Models\EquipmentType;

class EquipmentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return BaseCollection
     */
    public function getEquipmentType(): BaseCollection
    {
        return new BaseCollection(EquipmentType::all());
    }

}
