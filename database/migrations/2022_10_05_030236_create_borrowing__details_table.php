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
            $table->string('incident_id');
            $table->string('incident');
            $table->string('incident_summary');
            $table->string('file_path')->nullable();
            $table->string('filename')->nullable();
            $table->timestamp('INC_submitted_at')->nullable();
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
