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
        Schema::create('borrow_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('is_returned')->default(false);
            $table->foreignUuid('borrowing_detail_id')->constrained('borrowing_details');
            $table->integer('serviceable');
            $table->integer('poor');
            $table->integer('unusable');
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
        Schema::dropIfExists('borrow_histories');
    }
};
