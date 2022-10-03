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
        Schema::create('cross_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained();
            $table->integer('quantity');
            $table->foreignId('municipality_id')->constrained();
            $table->boolean('self_province_confirmation')->default(false);
            $table->boolean('rdrrmc_confirmation')->default(false);
            $table->boolean('reciever_province_confirmation')->default(false);
            $table->boolean('reciever_confirmation')->default(false);
            $table->boolean('returned')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('cross_transactions');
    }
};
