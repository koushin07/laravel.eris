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
        
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('municipality_id')->constrained();
            $table->string('equipment_name');
            $table->string('code');
            $table->string('asset_desc');
            $table->string('category');
            $table->integer('unit');
            $table->integer('model_number');
            $table->integer('serial_number');
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
        Schema::dropIfExists('equipment');
    }
};
