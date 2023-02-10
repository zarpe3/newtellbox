<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sip_routes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('accountCode');
            $table->string('ddd');
            $table->string('type');
            $table->string('trunk');
            $table->timestamps();

            ///$table->foreign('accountCode')->references('accountcode')->on('customer')->onDelete('cascade')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
