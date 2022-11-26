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
        Schema::create('borrowing_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('borrowing_id')->constrained('borrowings', 'id');
            $table->string('reason');
            $table->string('status');
            $table->foreignUuid('equipment_attrs')->nullable()->constrained('equipment_attributes');
            $table->foreignUuid('equipment_id')->constrained('equipment');
            $table->integer('quantity');
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
        Schema::dropIfExists('borrowing_details');
    }
};
