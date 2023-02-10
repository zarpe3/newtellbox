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
        Schema::create('queue_member', function (Blueprint $table) {
            $table->id();
            $table->string('uniqueid')->unique();
            $table->string('membername')->nullable(false);
            $table->string('queue_name', 128)->nullable(false);
            $table->string('interface')->nullable(false);
            $table->integer('penalty')->nullable();
            $table->integer('paused')->nullable();
            $table->timestamps();

            $table->unique(['membername', 'queue_name']);
            $table->index('queue_name');

            //$table->foreign('queue_name')->references('name')->on('queue')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('queue_member');
    }
};
