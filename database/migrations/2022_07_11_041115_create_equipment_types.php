<?php

use App\Models\EquipmentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mask_sn');
        });

        EquipmentType::create([
            'name' => 'TP-Link TL-WR74',
            'mask_sn' => 'XXAAAAAXAA',
        ]);

        EquipmentType::create([
            'name' => 'D-Link DIR-300',
            'mask_sn' => 'NXXAAXZXaa',
        ]);

        EquipmentType::create([
            'name' => 'D-Link DIR-300 S',
            'mask_sn' => 'NXXAAXZXXX',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_types');
    }
}
