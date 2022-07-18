<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentStoreRequest;
use App\Http\Requests\EquipmentUpdateRequest;
use App\Http\Resources\EquipmentStoreCollection;
use App\Http\Resources\EquipmentResource;
use App\Http\Services\EquipmentService;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param EquipmentService $service
     * @return AnonymousResourceCollection
     */
    public function index(Request $request, EquipmentService $service): AnonymousResourceCollection
    {
        $data = $service->getEquipmentList($request);

        return EquipmentResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EquipmentStoreRequest $request
     * @param EquipmentService $service
     * @return EquipmentStoreCollection
     */
    public function store(EquipmentStoreRequest $request, EquipmentService $service): EquipmentStoreCollection
    {
        $validated = $request->validated();

        $data = $service->createEquipments($validated['data']);

        return new EquipmentStoreCollection($data);
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
