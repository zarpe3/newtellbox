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
        Schema::create('ivrs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('name')->default('');
            $table->string('audio', 200);
            $table->integer('option_0')->nullable();
            $table->string('value_0')->nullable();
            $table->integer('option_1')->nullable();
            $table->string('value_1')->nullable();
            $table->integer('option_2')->nullable();
            $table->string('value_2')->nullable();
            $table->integer('option_3')->nullable();
            $table->string('value_3')->nullable();
            $table->integer('option_4')->nullable();
            $table->string('value_4')->nullable();
            $table->integer('option_5')->nullable();
            $table->string('value_5')->nullable();
            $table->integer('option_6')->nullable();
            $table->string('value_6')->nullable();
            $table->integer('option_7')->nullable();
            $table->string('value_7')->nullable();
            $table->integer('option_8')->nullable();
            $table->string('value_8')->nullable();
            $table->integer('option_9')->nullable();
            $table->string('value_9')->nullable();
            $table->integer('divert_option')->nullable();
            $table->string('divert_value')->nullable();
            $table->timestamp('stamp');
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
