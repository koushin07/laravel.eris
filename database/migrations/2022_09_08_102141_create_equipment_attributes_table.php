<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_attributes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('asset_desc');
            $table->string('category');
            $table->integer('unit');
            $table->string('model_number');
            $table->string('serial_number')->unique()->nullable();
            $table->integer('asset_id');
            $table->string('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_attributes');
    }
};
