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
        Schema::create('equipment_borrows', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('equipment_id')->constrained();
            $table->foreignUuid('equipment_attrs')->nullable()->constrained('equipment_attributes');
            $table->integer('quantity');
            $table->integer('acquired');
            $table->foreignUuid('detail_id')->nullable()->constrained('borrowing_details');
            $table->integer('authorize_quantity')->nullable();
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
        Schema::dropIfExists('equipment_borrows');
    }
};
