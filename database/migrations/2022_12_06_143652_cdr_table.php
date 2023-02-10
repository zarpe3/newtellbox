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
        Schema::create('cdr', function (Blueprint $table) {
            $table->id();
            $table->string('uniqueid');
            $table->string('accountCode');
            $table->string('src', 50);
            $table->string('dst', 50);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('billsec');
            $table->string('status');
            $table->string('audio')->nullable();
            $table->float('rating', 8, 2)->nullable();

            //$table->foreign('accountCode')->references('accountcode')->on('customer')->onDelete('cascade')->unsigned();
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
