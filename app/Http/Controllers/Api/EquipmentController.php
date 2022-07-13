<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentStoreRequest;
use App\Http\Requests\EquipmentUpdateRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\EquipmentResource;
use App\Http\Services\EquipmentService;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param EquipmentService $service
     * @return BaseCollection
     */
    public function index(Request $request, EquipmentService $service): BaseCollection
    {
        $data = $service->getEquipmentList($request);

        return new BaseCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EquipmentStoreRequest $request
     * @param EquipmentService $service
     * @return BaseCollection
     */
    public function store(EquipmentStoreRequest $request, EquipmentService $service): BaseCollection
    {
        $validated = $request->validated();

        $data = $service->createEquipments($validated['data']);

        return new BaseCollection($data);
    }

    /**
     * Display the specified resource.
     *
     * @param Equipment $equipment
     * @return EquipmentResource
     */
    public function show(Equipment $equipment): EquipmentResource
    {
        return new EquipmentResource($equipment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EquipmentUpdateRequest $request
     * @param Equipment $equipment
     * @param EquipmentService $service
     * @return EquipmentResource
     */
    public function update(EquipmentUpdateRequest $request, Equipment $equipment, EquipmentService $service): EquipmentResource
    {
        $validated = $request->validated();

        $updatedEquipment = $service->updateEquipmentData($validated, $equipment);

        return new EquipmentResource($updatedEquipment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Equipment $equipment
     * @return EquipmentResource
     */
    public function destroy(Equipment $equipment): EquipmentResource
    {
        $equipment->delete();

        return new EquipmentResource($equipment);
    }
}
