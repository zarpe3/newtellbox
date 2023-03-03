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
        Schema::create('voicemails_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('context')->default('');
            $table->string('mailbox', 11)->default('');
            $table->string('password', 200);
            $table->string('fullname', 150)->default('');
            $table->string('email')->default('suporte@webdec.com.br');
            $table->string('pager', 50)->default('');
            $table->string('tz', 10)->default('gmt');
            $table->string('attach', 4)->default('yes');
            $table->string('saycid', 4)->default('yes');
            $table->string('dialout', 10)->default('');
            $table->string('callback', 10)->default('');
            $table->string('review', 4)->default('no');
            $table->string('operator', 4)->default('no');
            $table->string('envelope', 5)->default('yes');
            $table->string('sayduration', 4)->default('no');
            $table->tinyInteger('saydurationm')->default(1);
            $table->string('sendvoicemail', 4)->default('no');
            $table->string('delete', 4)->default('no');
            $table->string('nextaftercmd', 4)->default('yes');
            $table->string('forcename', 4)->default('no');
            $table->string('forcegreetings', 4)->default('no');
            $table->string('hidefromdir', 4)->default('yes');
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
