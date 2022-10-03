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
        Schema::table('municipality_transactions', function (Blueprint $table) {
            $table->tinyInteger('confirm')->after('municipality_id')->default(1);
            $table->boolean('returned')->after('confirm')->default(0);       
            $table->softDeletes();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('municipality_transactions', function (Blueprint $table) {
            //
        });
    }
};
