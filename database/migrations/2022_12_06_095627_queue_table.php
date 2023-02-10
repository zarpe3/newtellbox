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
        Schema::create('queue', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('name', 128)->nullable(false);
            $table->string('musiconhold')->nullable();
            $table->string('announce')->nullable();
            $table->string('context')->nullable();
            $table->integer('timeout')->nullable();
            $table->integer('monitor_join')->nullable();
            $table->string('monitor_format')->nullable();
            $table->string('queue_youarenext')->nullable();
            $table->string('queue_thereare')->nullable();
            $table->string('queue_callswaiting')->nullable();
            $table->string('queue_holdtime')->nullable();
            $table->string('queue_minutes')->nullable();
            $table->string('queue_seconds')->nullable();
            $table->string('queue_lessthan')->nullable();
            $table->string('queue_thankyou')->nullable();
            $table->string('queue_reporthold')->nullable();
            $table->integer('announce_frequency')->nullable();
            $table->integer('announce_round_seconds')->nullable();
            $table->string('announce_holdtime')->nullable();
            $table->integer('retry')->nullable()->default(0);
            $table->integer('wrapuptime')->nullable();
            $table->integer('maxlen')->nullable();
            $table->integer('servicelevel')->nullable();
            $table->string('strategy')->nullable();
            $table->string('joinempty')->nullable();
            $table->string('leavewhenempty')->nullable();
            $table->integer('eventmemberstatus')->nullable()->default(1);
            $table->integer('eventwhencalled')->nullable()->default(1);
            $table->integer('reportholdtime')->nullable();
            $table->integer('memberdelay')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('timeoutrestart')->nullable();
            $table->string('periodic_announce')->nullable();
            $table->integer('periodic_announce_frequency')->nullable();
            $table->integer('ringinuse')->nullable()->default(1);
            $table->integer('setinterfacevar')->default(1);

            $table->timestamps();

            $table->unique('name');

            //$table->foreignId('customer_id')->references('id')->on('customer')->onDelete('cascade');
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
