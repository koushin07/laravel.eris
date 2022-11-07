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
        Schema::create('unfinish_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrower')->constrained('offices');
            $table->foreignId('owner')->constrained('offices');
            $table->integer('quantity');
            $table->string('equipment');
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
        Schema::dropIfExists('unfinish_transactions');
    }
};
