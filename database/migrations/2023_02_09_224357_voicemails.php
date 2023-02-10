<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table->id();
        $table->unsignedBigInteger('customer_id');
        $table->string('name');
        $table->string('duration', 20);
        $table->integer('msg_num');
        $table->string('dst', 40);
        $table->string('src', 40);
        $table->dateTime('created_at');
        $table->dateTime('updated_at');
        $table->string('audio');
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
